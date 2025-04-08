<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Illuminate\Database\Eloquent\{
    Builder, Collection, Model
};
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleEmployee\Contracts\Schemas\EmployeeSchedule as ContractsEmployeeSchedule;
use Hanafalah\ModuleEmployee\Contracts\Data\CardIdentityData;
use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeScheduleData;
use Hanafalah\ModuleEmployee\Contracts\Data\ProfileEmployeeScheduleData;
use Hanafalah\ModuleEmployee\Contracts\Data\ProfilePhotoData;
use Hanafalah\ModuleEmployee\Contracts\Schemas\ProfileEmployeeSchedule;
use Hanafalah\ModuleEmployee\Contracts\Schemas\ProfilePhoto;
use Hanafalah\ModuleEmployee\Enums\EmployeeSchedule\CardIdentity;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class EmployeeSchedule extends PackageManagement implements ContractsEmployeeSchedule,ProfileEmployeeSchedule,ProfilePhoto
{
    protected string $__entity = 'EmployeeSchedule';
    public static $employee_schedule_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'employee_schedule',
            'tags'     => ['employee_schedule', 'employee_schedule-index'],
            'duration' => 60 * 24 * 7
        ]
    ];

    protected function viewUsingRelation(): array{
        return [];
    }

    protected function showUsingRelation(): array{
        return [];
    }

    public function getEmployeeSchedule(): mixed{
        return static::$employee_schedule_model;
    }

    public function prepareShowEmployeeSchedule(?Model $model = null, ?array $attributes = null): Model{
        $attributes ??= request()->all();

        $model ??= $this->getEmployeeSchedule();
        if (!isset($model)) {
            $id   = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('id or uuid not found');

            $model = $this->employeeSchedule()->with($this->showUsingRelation())->findOrFail($id);            
        } else {
            $model->load($this->showUsingRelation());
        }
        return static::$employee_schedule_model = $model;
    }    

    public function showEmployeeSchedule(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowEmployeeSchedule($model);
        });
    }

    public function prepareStoreEmployeeSchedule(EmployeeScheduleData $employee_schedule_dto): Model{
        return static::$employee_schedule_model = $employee_schedule;
    }

    public function storeEmployeeSchedule(? EmployeeScheduleData $employee_schedule_dto = null): array{
        return $this->transaction(function () use ($employee_schedule_dto) {
            return $this->showEmployeeSchedule($this->prepareStoreEmployeeSchedule($employee_schedule_dto ?? $this->requestDTO(EmployeeScheduleData::class)));
        });
    }

    public function prepareViewEmployeeSchedulePaginate(PaginateData $paginate_dto): LengthAwarePaginator{
        return $this->employeeSchedule()->with($this->viewUsingRelation())->paginate(...$paginate_dto->toArray())->appends(request()->all());
    }

    public function viewEmployeeSchedulePaginate(? PaginateData $paginate_dto = null): array{
        return $this->viewEntityResource(function() use ($paginate_dto){            
            return $this->prepareViewEmployeeSchedulePaginate($paginate_dto ?? $this->requestDTO(PaginateData::class));
        });
    }

    public function prepareViewEmployeeScheduleList(): Collection{
        return $this->employeeSchedule()->with($this->viewUsingRelation())->get();
    }

    public function viewEmployeeScheduleList(): array{
        return $this->viewEntityResource(function(){
            return $this->prepareViewEmployeeScheduleList();
        });
    }

    public function prepareDeleteEmployeeSchedule(? array $attributes = null): bool{
        $attributes ??= request()->all();
        if (!isset($attributes['id']) && !isset($attributes['uuid'])){
            throw new \Exception('id or uuid not found');
        }

        $employee_schedule = $this->employeeSchedule()
            ->when(isset($attributes['id']),function($query) use ($attributes){
                $query->where('id', $attributes['id']);
            })
            ->when(isset($attributes['uuid']),function($query) use ($attributes){
                $query->whereHas('userReference',function($query) use ($attributes){
                    $query->where('uuid', $attributes['uuid']);
                });
            })
            ->firstOrFail();
        return $employee_schedule->delete();
    }

    public function deleteEmployeeSchedule(): bool{
        return $this->transaction(function(){
            return $this->prepareDeleteEmployeeSchedule();
        });
    }

    public function employeeSchedule(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->EmployeeScheduleModel()->conditionals($this->mergeCondition($conditionals))->withParameters('or')->orderBy('name','asc');
    }
}

