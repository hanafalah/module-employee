<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Illuminate\Database\Eloquent\{
    Builder,
    Model
};
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleEmployee\Contracts\Employee as ContractsEmployee;
use Hanafalah\ModuleEmployee\Resources\Employee\{ShowEmployee, ViewEmployee};

class Employee extends PackageManagement implements ContractsEmployee
{
    protected array $__guard   = ['id'];
    protected array $__add     = ['profession_id', 'people_id', 'status', 'hired_at'];
    protected string $__entity = 'Employee';
    public static $employee_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'employee',
            'tags'     => ['employee', 'employee-index'],
            'duration' => 60 * 24 * 7
        ]
    ];

    protected array $__resources = [
        'view' => ViewEmployee::class,
        'show' => ShowEmployee::class
    ];

    public function prepareStoreEmployee(?array $attributes = null): Model
    {
        $attributes ??= request()->all();
        $people_schema = $this->schemaContract('people');
        if (isset($attributes['id'])) {
            $guard    = ['id' => $attributes['id']];
            $employee = $this->EmployeeModel()->find($attributes['id']);
            $attributes['people_id']    = $employee->people_id;

            $people_attr = $attributes;
            $people_attr['id'] = $employee->people_id;

            $people = $people_schema->prepareStorePeople($people_attr);
        } else {
            $people = $people_schema->prepareStorePeople($attributes['people']);
            $guard = ['people_id' => $attributes['people_id'] ?? $people->getKey()];
        }

        if (!isset($attributes['is_profile'])) {
            $employee = $this->employee()->updateOrCreate($guard, [
                'sallary'       => $attributes['sallary'] ?? 0,
                'profession_id' => $attributes['profession_id'] ?? null
            ]);
        }

        $people->load('cardIdentities');
        $employee->name     = $people->name;
        $employee->hired_at = $attributes['hired_at'] ?? null;
        $employee->nip      = $attributes['nip'] ?? null;
        $employee->nik      = $attributes['nik'] ?? null;
        $employee->sync($people, $people->toViewApi()->resolve());
        $employee->save();
        return static::$employee_model = $employee;
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

    public function showUsingRelation(): array
    {
        return [
            'people'        => fn($q) => $q->with(['addresses', 'cardIdentities']),
            'userReference' => fn($q) => $q->with(['roles', 'user']),
            'profession',
            'cardIdentities'
        ];
    }

    public function viewUsingRelation(): array
    {
        return ['people.cardIdentities', 'userReference'];
    }

    public function showEmployee(?Model $model = null): array
    {
        return $this->transforming($this->__resources['show'], function () use ($model) {
            return $this->prepareShowEmployee($model);
        });
    }

    public function storeEmployee(): array
    {
        return $this->transaction(function () {
            return $this->showEmployee($this->prepareStoreEmployee());
        });
    }

    public function getEmployee(): mixed
    {
        return static::$employee_model;
    }

    public function addOrChange(?array $attributes = []): self
    {
        $employee = $this->updateOrCreate($attributes);
        if (isset($attributes['parent']) && \method_exists($this->getModel(), 'sync')) {
            $employee->sync($attributes['parent_model']);
        }
        static::$employee_model = $employee;
        return $this;
    }

    public function employee(mixed $conditionals = null): Builder
    {
        $this->booting();
        return $this->EmployeeModel()->conditionals($conditionals)
            ->withParameters('or')->with($this->viewUsingRelation());
    }
}
