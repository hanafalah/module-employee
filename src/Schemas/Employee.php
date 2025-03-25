<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Illuminate\Database\Eloquent\{
    Builder,
    Model
};
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleEmployee\Contracts\Employee as ContractsEmployee;
use Hanafalah\ModuleEmployee\Data\EmployeeData;
use Hanafalah\ModuleEmployee\Resources\Employee\{ShowEmployee, ViewEmployee};

class Employee extends PackageManagement implements ContractsEmployee
{
    protected array $__guard   = ['id'];
    protected array $__add     = ['profession_id', 'people_id', 'status', 'hired_at', 'profile'];
    protected string $__entity = 'Employee';
    public static $employee_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'employee',
            'tags'     => ['employee', 'employee-index'],
            'duration' => 60 * 24 * 7
        ]
    ];

    public function showUsingRelation(): array{
        return [
            'people'        => fn($q) => $q->with(['addresses', 'cardIdentities']),
            'userReference' => fn($q) => $q->with(['roles', 'user']),
            'profession',
            'cardIdentities'
        ];
    }


    public function viewUsingRelation(): array{
        return ['people.cardIdentities'];
    }

    public function getEmployee(): mixed{
        return static::$employee_model;
    }

    public function prepareShowEmployee(?Model $model = null, ?array $attributes = null): Model
    {
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

        $people->load('cardIdentities');
        $employee->name     = $people->name;
        $employee->hired_at = $attributes['hired_at'] ?? null;
        $employee->nip      = $attributes['nip'] ?? null;
        $employee->nik      = $attributes['nik'] ?? null;
        $employee->sync($people, $people->toViewApi()->resolve());
        $employee->save();
        return static::$employee_model = $employee;
    }

    public function storeEmployee(? EmployeeData $employee_dto = null): array{
        return $this->transaction(function () use ($employee_dto) {
            return $this->showEmployee($this->prepareStoreEmployee($employee_dto ?? EmployeeData::from(request()->all())));
        });
    }

    public function employee(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->EmployeeModel()->conditionals($conditionals)->withParameters('or');
    }
}
