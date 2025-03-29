<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Hanafalah\LaravelSupport\Supports\Data;
use Illuminate\Database\Eloquent\{
    Builder,
    Collection,
    Model
};
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleEmployee\Contracts\Schemas\Employee as ContractsEmployee;
use Hanafalah\ModuleEmployee\Contracts\Data\CardIdentityData;
use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeData;
use Hanafalah\ModuleEmployee\Contracts\Data\ProfileEmployeeData;
use Hanafalah\ModuleEmployee\Contracts\Data\ProfilePhotoData;
use Hanafalah\ModuleEmployee\Contracts\Schemas\ProfileEmployee;
use Hanafalah\ModuleEmployee\Contracts\Schemas\ProfilePhoto;
use Hanafalah\ModuleEmployee\Enums\Employee\CardIdentity;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class Employee extends PackageManagement implements ContractsEmployee,ProfileEmployee,ProfilePhoto
{
    protected string $__entity = 'Employee';
    public static $employee_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'employee',
            'tags'     => ['employee', 'employee-index'],
            'duration' => 60 * 24 * 7
        ]
    ];

    protected function viewUsingRelation(): array{
        return ['people.cardIdentities'];
    }

    protected function showUsingRelation(): array{
        return [
            'people'        => fn($q) => $q->with(['addresses', 'cardIdentities']),
            'userReference' => fn($q) => $q->with(['roles', 'user']),
            'profession',
            'cardIdentities'
        ];
    }

    public function getEmployee(): mixed{
        return static::$employee_model;
    }

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
        return static::$employee_model = $model;
    }    

    protected function getEmployeeByIdentifier(array $attributes){
        $id = $attributes['id'] ?? null;
        $uuid = $attributes['uuid'] ?? null;
        return $this->employee()->with($this->showUsingRelation())
                ->when(isset($id), fn($q) => $q->where('id', $id))
                ->when(isset($uuid), function ($query) use ($uuid) {
                    $query->whereHas('userReference', fn($q) => $q->uuid($uuid));
                });
    }

    public function showEmployee(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowEmployee($model);
        });
    }

    public function prepareShowProfile(?Model $model = null, ?array $attributes = null): Model{
        $attributes ??= \request()->all();
        if (!isset($attributes['uuid'])) throw new \Exception('uuid not found');
        return static::$employee_model = $this->employee()->with($this->showUsingRelation())->whereHas('userReference',function($query) use ($attributes){
            $query->uuid($attributes['uuid']);
        })->firstOrFail();
    }

    public function showProfile(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowProfile($model);
        });
    }

    protected function prepareEmployeePeople(EmployeeData $employee_dto): array{
        $people_schema = $this->schemaContract('people');
        if (isset($employee_dto->id)) {
            $guard                    = ['id' => $employee_dto->id];
            $employee                 = $this->EmployeeModel()->findOrFail($employee_dto->id);
            $employee_dto->people->id = $employee->people_id;

            $people = $people_schema->prepareStorePeople($employee_dto->people);
        } else {
            $people = $people_schema->prepareStorePeople($employee_dto->people);
            $guard = ['people_id' => $employee_dto->people->id ?? $people->getKey()];
        }
        $employee = $this->employee()->updateOrCreate($guard);

        $people ??= $employee->people;

        $employee->sync($people);
        $employee->name = $people->name;
        //SET EMPLOYEE IDENTITIES
        if (isset($employee_dto->card_identity)){
            $card_identity = $employee_dto->card_identity;
            $this->employeeIdentity($employee, $card_identity,array_column(CardIdentity::cases(),'value'));
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
        $employee->save();

        //MANAGE EMPLOYEE ACCOUNT/USER ACCESS
        if (isset($employee_dto->user)){
            $user_reference = &$employee_dto->user->user_reference;
            $user_reference->reference_id   = $employee->getKey();
            $user_reference->reference_type = $employee->getMorphClass();
            $this->schemaContract('user')->prepareStoreUser($employee_dto->user);
        }
        return static::$employee_model = $employee;
    }

    public function storeEmployee(? EmployeeData $employee_dto = null): array{
        return $this->transaction(function () use ($employee_dto) {
            return $this->showEmployee($this->prepareStoreEmployee($employee_dto ?? $this->requestDTO(EmployeeData::class)));
        });
    }

    public function prepareStoreProfile(ProfileEmployeeData $profile_employee_dto): Model{
        if (!isset($profile_employee_dto->id)) throw new \Exception('id or uuid not found');

        list($employee,$people) = $this->prepareEmployeePeople($profile_employee_dto);
        return static::$employee_model = $employee;
    }

    public function storeProfile(? ProfileEmployeeData $profile_employee_dto = null): array{
        return $this->transaction(function() use ($profile_employee_dto){
            return $this->showEmployee($this->prepareStoreProfile($profile_employee_dto ?? $this->requestDTO(ProfileEmployeeData::class)));
        });
    }

    public function prepareStoreProfilePhoto(ProfilePhotoData $profile_photo_dto): Model{
        if (!isset($profile_photo_dto->id)) throw new \Exception('id or uuid not found');
        $employee = $this->employee()->findOrFail($profile_photo_dto->id);
        $employee->setProfilePhoto($profile_photo_dto->profile);
        return static::$employee_model = $employee;
    }

    public function storeProfilePhoto(?ProfilePhotoData $profile_photo_dto = null): array{
        return $this->transaction(function() use ($profile_photo_dto){
            return $this->showPrfilePhoto($this->prepareStoreProfilePhoto($profile_photo_dto ?? $this->requestDTO(ProfilePhotoData::class)));
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

    public function prepareViewEmployeePaginate(PaginateData $paginate_dto): LengthAwarePaginator{
        return $this->employee()->with($this->viewUsingRelation())->paginate(...$paginate_dto->toArray())->appends(request()->all());
    }

    public function viewEmployeePaginate(? PaginateData $paginate_dto = null): array{
        return $this->viewEntityResource(function() use ($paginate_dto){            
            return $this->prepareViewEmployeePaginate($paginate_dto ?? $this->requestDTO(PaginateData::class));
        });
    }

    public function prepareViewEmployeeList(): Collection{
        return $this->employee()->with($this->viewUsingRelation())->get();
    }

    public function viewEmployeeList(): array{
        return $this->viewEntityResource(function(){
            return $this->prepareViewEmployeeList();
        });
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

    public function deleteEmployee(): bool{
        return $this->transaction(function(){
            return $this->prepareDeleteEmployee();
        });
    }

    public function employee(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->EmployeeModel()->conditionals($this->mergeCondition($conditionals))->withParameters('or')->orderBy('props->prop_people->name','asc');
    }
}

