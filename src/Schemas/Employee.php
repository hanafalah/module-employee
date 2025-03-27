<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Illuminate\Database\Eloquent\{
    Builder,
    Collection,
    Model
};
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleEmployee\Contracts\Schemas\Employee as ContractsEmployee;
use Hanafalah\ModuleEmployee\Data\CardIdentityData;
use Hanafalah\ModuleEmployee\Data\EmployeeData;
use Hanafalah\ModuleEmployee\Enums\Employee\CardIdentity;
use Illuminate\Support\Str;

class Employee extends PackageManagement implements ContractsEmployee
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

    public function viewUsingRelation(): array{
        return ['people.cardIdentities'];
    }

    public function showUsingRelation(): array{
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

            $model = $this->employee()->with($this->showUsingRelation())
                ->when(isset($id), fn($q) => $q->where('id', $id))
                ->when(isset($uuid), function ($query) use ($uuid) {
                    $query->whereHas('userReference', fn($q) => $q->uuid($uuid));
                })->first();
        } else {
            $model->load($this->showUsingRelation());
        }
        return static::$employee_model = $model;
    }    

    public function showEmployee(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowEmployee($model);
        });
    }

    public function prepareStoreEmployee(EmployeeData $employee_dto): Model{
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
        $employee = $this->employee()->updateOrCreate($guard, [
            'profession_id' => $employee_dto->profession_id,
            'hired_at'      => $employee_dto->hired_at
        ]);

        $people ??= $employee->people;
        $employee->sync($people);

        $employee->name     = $people->name;
        $employee->hired_at = $attributes['hired_at'] ?? null;

        //SET EMPLOYEE IDENTITIES
        if (isset($employee_dto->card_identity)){
            $card_identity = $employee_dto->card_identity;
            $this->employeeIdentity($employee, $card_identity,array_column(CardIdentity::cases(),'value'));
        }
        $employee->save();

        //MANAGE EMPLOYEE ACCOUNT/USER ACCESS
        if (isset($employee_dto->user)){
            $this->schemaContract('user')->prepareStoreUser($employee_dto->user);
        }
        return static::$employee_model = $employee;
    }

    public function storeEmployee(? EmployeeData $employee_dto = null): array{
        return $this->transaction(function () use ($employee_dto) {
            return $this->showEmployee($this->prepareStoreEmployee($employee_dto ?? $this->requestDTO(EmployeeData::class)));
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

    public function prepareViewEmployeeList(): Collection{
        return $this->employee()->with($this->viewUsingRelation())->get();
    }

    public function viewEmployeeList(): array{
        return $this->viewEntityResource(function(){
            return $this->prepareViewEmployeeList();
        });
    }

    public function employee(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->EmployeeModel()->conditionals($this->mergeCondition($conditionals))->withParameters('or')->orderBy('props->prop_people->name','asc');
    }
}

