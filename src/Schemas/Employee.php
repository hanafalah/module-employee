<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Illuminate\Database\Eloquent\{
    Builder, Model
};
use Hanafalah\ModuleEmployee\Supports\BaseModuleEmployee;
use Hanafalah\ModuleEmployee\Contracts\Schemas\Employee as ContractsEmployee;
use Hanafalah\ModuleEmployee\Contracts\Data\CardIdentityData;
use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeData;
use Hanafalah\ModuleEmployee\Contracts\Data\ProfileEmployeeData;
use Hanafalah\ModuleEmployee\Contracts\Data\ProfilePhotoData;
use Hanafalah\ModuleEmployee\Contracts\Schemas\ProfileEmployee;
use Hanafalah\ModuleEmployee\Contracts\Schemas\ProfilePhoto;
use Hanafalah\ModuleEmployee\Enums\Employee\CardIdentity;
use Illuminate\Support\Str;

class Employee extends BaseModuleEmployee implements ContractsEmployee, ProfileEmployee, ProfilePhoto
{
    protected string $__entity = 'Employee';
    public $employee_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'employee',
            'tags'     => ['employee', 'employee-index'],
            'duration' => 60 * 24 * 7
        ]
    ];

    public function prepareShowEmployee(?Model $model = null, ?array $attributes = null): Model{
        $attributes ??= request()->all();

        $model ??= $this->getEmployee();
        if (!isset($model)) {
            $id   = $attributes['id'] ?? null;
            $uuid = $attributes['uuid'] ?? null;
            $is_valid = isset($id) || isset($uuid);
            if (!$is_valid) throw new \Exception('id or uuid not found');
            $model = $this->getEmployeeByIdentifier($attributes)->firstOrFail();            
        } else {
            $model->load($this->showUsingRelation());
        }
        return $this->employee_model = $model;
    }    

    protected function getEmployeeByIdentifier(array $attributes){
        $id = $attributes['id'] ?? null;
        $uuid = $attributes['uuid'] ?? null;
        return $this->employee()->with($this->showUsingRelation())
                ->when(isset($id), fn($q) => $q->where('id', $id))
                ->when(isset($uuid), function ($query) use ($uuid) {
                    return $query->whereHas('userReference', fn($q) => $q->uuid($uuid));
                });
    }

    public function prepareShowProfile(?Model $model = null, ?array $attributes = null): Model{
        $attributes ??= \request()->all();
        if (!isset($attributes['uuid'])) throw new \Exception('uuid not found');
        return $this->employee_model = $this->employee()->with($this->showUsingRelation())->whereHas('userReference',function($query) use ($attributes){
            $query->uuid($attributes['uuid']);
        })->firstOrFail();
    }

    public function showProfile(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowProfile($model);
        });
    }

    protected function prepareEmployeePeople(EmployeeData|ProfileEmployeeData $employee_dto): array{
        $people_schema = $this->schemaContract('people');
        $add = [
            'name' => $employee_dto->name
        ];
        if (isset($employee_dto->id) || isset($employee_dto->uuid)){ 
            $employee = $this->getEmployeeByIdentifier([
                'id'   => $employee_dto->id ?? null,
                'uuid' => $employee_dto->uuid ?? null
            ])->firstOrFail();            
            
            if (isset($employee_dto->uuid)) $guard = ['uuid' => $employee_dto->uuid];
            if (isset($employee_dto->id))   $guard = ['id' => $employee_dto->id];

            $employee_dto->people->id   = $employee->people_id;
            $employee_dto->people->uuid = $employee->people->uuid;
            $people = $people_schema->prepareStorePeople($employee_dto->people);
        } else {
            $people = $people_schema->prepareStorePeople($employee_dto->people);
            $guard = ['people_id' => $employee_dto->people->id ?? $people->getKey()];
        }
        $employee = $this->employee()->updateOrCreate($guard,$add);
        $employee->refresh();        
        
        $people ??= $employee->people;

        $employee->sync($people);
        $employee->name = $people->name;
        //SET EMPLOYEE IDENTITIES
        if (isset($employee_dto->card_identity)){
            $this->employeeIdentity(
                $employee, 
                $employee_dto->card_identity,
                array_column(config('module-employee.employee_identities'),'value')
            );
        }
        $this->prepareStoreProfilePhoto($employee_dto->profile_dto ?? $this->requestDTO(ProfilePhotoData::class,[
            'id'      => $employee->getKey(),
            'profile' => $employee_dto->profile
        ]));
        return [$employee,$people];
    }

    public function prepareStoreEmployee(EmployeeData $employee_dto): Model{
        list($employee,$people)  = $this->prepareEmployeePeople($employee_dto);
        $employee->hired_at      = $employee_dto->hired_at ?? null;        
        $employee->profession_id = $employee_dto->profession_id ?? null;
        $employee->occupation_id = $employee_dto->occupation_id ?? null;
        $employee->shift_id      = $employee_dto->shift_id ?? null;
        $this->fillingProps($employee,$employee_dto->props);
        $employee->save();
        //MANAGE EMPLOYEE ACCOUNT/USER ACCESS
        if (isset($employee_dto->user_reference)){
            $user_reference_dto                 = $employee_dto->user_reference;
            $user_reference_dto->id             = $employee->userReference->getKey();
            $user_reference_dto->uuid           = $employee->uuid;
            $user_reference_dto->reference_id   = $employee->getKey();
            $user_reference_dto->reference_type = $employee->getMorphClass();
            $user_reference = $this->schemaContract('user_reference')->prepareStoreUserReference($user_reference_dto);
        }
        return $this->employee_model = $employee;
    }

    public function prepareStoreProfile(ProfileEmployeeData $profile_employee_dto): Model{
        if (!isset($profile_employee_dto->id) && !isset($profile_employee_dto->uuid)) throw new \Exception('id or uuid not found');

        list($employee,$people) = $this->prepareEmployeePeople($profile_employee_dto);
        return $this->employee_model = $employee;
    }

    public function storeProfile(? ProfileEmployeeData $profile_employee_dto = null): array{
        return $this->transaction(function() use ($profile_employee_dto){
            return $this->showEmployee($this->prepareStoreProfile($profile_employee_dto ?? $this->requestDTO(ProfileEmployeeData::class)));
        });
    }

    public function prepareShowProfilePhoto(? Model $model = null, ?array $attributes = null): mixed{
        $attributes ??= \request()->all();
        $model ??= $this->getEmployee();
        if (!isset($model)){
            $id   = $attributes['id'] ?? null;
            $uuid = $attributes['uuid'] ?? null;
            if (!isset($id) && !isset($uuid)) throw new \Exception('id or uuid not found');
            $model = $this->getEmployeeByIdentifier($attributes)->firstOrFail();
        }
        $this->employee_model = $model;
        if (isset($attributes['is_direct_photo']) && $attributes['is_direct_photo']) {
            return $model->getProfilePhoto();
        }else{
            return $model;
        }
    }

    public function showProfilePhoto(? Model $model = null): mixed{
        $is_json = (strpos(request()->header('accept'), 'application/json') === 0);
        if ($is_json){
            return $this->transforming($this->usingEntity()->getViewFileResource(),function() use ($model){
                return $this->prepareShowProfilePhoto($model,request()->all());
            });
        }else{
            $attributes = \request()->all();
            $attributes['is_direct_photo'] = true;
            return $this->prepareShowProfilePhoto($model,$attributes);
        }
    }

    public function prepareStoreProfilePhoto(ProfilePhotoData $profile_photo_dto): Model{
        if (!isset($profile_photo_dto->id) && !isset($profile_photo_dto->uuid)) throw new \Exception('id or uuid not found');
        $employee = $this->getEmployeeByIdentifier(['id' => $profile_photo_dto->id, 'uuid' => $profile_photo_dto->uuid])->firstOrFail();
        $employee->profile = $employee->setProfilePhoto($profile_photo_dto->profile);
        $employee->save();
        return $this->employee_model = $employee;
    }

    public function storeProfilePhoto(?ProfilePhotoData $profile_photo_dto = null): array{
        return $this->transaction(function() use ($profile_photo_dto){
            return $this->showProfilePhoto($this->prepareStoreProfilePhoto($profile_photo_dto ?? $this->requestDTO(ProfilePhotoData::class)));
        });
    }

    protected function employeeIdentity(Model &$employee, CardIdentityData $card_identity_dto, array $types){
        $card_identity = [];
        foreach ($types as $type) {
            $lower_type = Str::lower($type);
            $value = $card_identity_dto->{$lower_type} ?? null;
            if (isset($value)) $employee->setCardIdentity($type, $card_identity_dto->{$lower_type});
            $card_identity[$lower_type] = $value;
        }
        $employee->setAttribute('prop_card_identity',$card_identity);
    }

    public function prepareDeleteEmployee(? array $attributes = null): bool{
        $attributes ??= request()->all();
        if (!isset($attributes['id']) && !isset($attributes['uuid'])){
            throw new \Exception('id or uuid not found');
        }

        $employee = $this->employee()
            ->when(isset($attributes['id']),function($query) use ($attributes){
                $query->where('id', $attributes['id']);
            })
            ->when(isset($attributes['uuid']),function($query) use ($attributes){
                $query->whereHas('userReference',function($query) use ($attributes){
                    $query->where('uuid', $attributes['uuid']);
                });
            })
            ->firstOrFail();
        return $employee->delete();
    }

    public function employee(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->EmployeeModel()->conditionals($this->mergeCondition($conditionals))
                    ->withParameters('or')->orderBy('props->prop_people->name','asc');
    }
}

