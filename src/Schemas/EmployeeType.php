<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Illuminate\Database\Eloquent\{
    Builder,
    Collection,
    Model
};
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleEmployee\Contracts\Schemas\EmployeeType as ContractsEmployeeType;
use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeTypeData;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeType extends PackageManagement implements ContractsEmployeeType
{
    protected string $__entity = 'EmployeeType';
    public static $employee_type_model;

    protected function viewUsingRelation(): array{
        return [];
    }

    protected function showUsingRelation(): array{
        return [];
    }

    public function getEmployeeType(): mixed{
        return static::$employee_type_model;
    }

    public function prepareShowEmployeeType(?Model $model = null, ?array $attributes = null): Model{
        $attributes ??= request()->all();

        $model ??= $this->getEmployeeType();
        if (!isset($model)) {
            $id   = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('id not found');

            $model = $this->employeeType()->with($this->showUsingRelation())->findOrFail($id);            
        } else {
            $model->load($this->showUsingRelation());
        }
        return static::$employee_type_model = $model;
    }    

    public function showEmployeeType(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowEmployeeType($model);
        });
    }

    public function prepareStoreEmployeeType(EmployeeTypeData $employee_type_dto): Model{
        $employee_type = $this->employeeType()->updateOrCreate([
            'id' => $employee_type_dto->id ?? null
        ],[
            'name'   => $employee_type_dto->name,            
            'note'   => $employee_type_dto->note ?? null
        ]);
        return static::$employee_type_model = $employee_type;
    }

    public function storeEmployeeType(? EmployeeTypeData $employee_type_dto = null): array{
        return $this->transaction(function () use ($employee_type_dto) {
            return $this->showEmployeeType($this->prepareStoreEmployeeType($employee_type_dto ?? $this->requestDTO(EmployeeTypeData::class)));
        });
    }

    public function prepareViewEmployeeTypePaginate(PaginateData $paginate_dto): LengthAwarePaginator{
        return $this->employeeType()->with($this->viewUsingRelation())->paginate(...$paginate_dto->toArray())->appends(request()->all());
    }

    public function viewEmployeeTypePaginate(? PaginateData $paginate_dto = null): array{
        return $this->viewEntityResource(function() use ($paginate_dto){            
            return $this->prepareViewEmployeeTypePaginate($paginate_dto ?? $this->requestDTO(PaginateData::class));
        });
    }

    public function prepareViewEmployeeTypeList(): Collection{
        return $this->employeeType()->with($this->viewUsingRelation())->get();
    }

    public function viewEmployeeTypeList(): array{
        return $this->viewEntityResource(function(){
            return $this->prepareViewEmployeeTypeList();
        });
    }

    public function prepareDeleteEmployeeType(? array $attributes = null): bool{
        $attributes ??= request()->all();
        if (!isset($attributes['id'])) throw new \Exception('id not found');

        $employee_type = $this->employeeType()->findOrFail($attributes['id']);
        return $employee_type->delete();
    }

    public function deleteEmployeeType(): bool{
        return $this->transaction(function(){
            return $this->prepareDeleteEmployeeType();
        });
    }

    public function employeeType(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->EmployeeTypeModel()->conditionals($this->mergeCondition($conditionals))->withParameters()->orderBy('name','asc');
    }
}

