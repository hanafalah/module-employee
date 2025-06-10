<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Illuminate\Database\Eloquent\{
    Builder,
    Collection,
    Model
};
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleEmployee\Contracts\Schemas\Attendence as ContractsAttendence;
use Hanafalah\ModuleEmployee\Contracts\Data\AttendenceData;
use Illuminate\Pagination\LengthAwarePaginator;

class Attendence extends PackageManagement implements ContractsAttendence
{
    protected string $__entity = 'Attendence';
    public static $attendence_model;

    protected function viewUsingRelation(): array{
        return [];
    }

    protected function showUsingRelation(): array{
        return [
            'employee','author'
        ];
    }

    public function getAttendence(): mixed{
        return static::$attendence_model;
    }

    public function prepareShowAttendence(?Model $model = null, ?array $attributes = null): Model{
        $attributes ??= request()->all();

        $model ??= $this->getAttendence();
        if (!isset($model)) {
            $id   = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('id not found');

            $model = $this->attendence()->with($this->showUsingRelation())->findOrFail($id);            
        } else {
            $model->load($this->showUsingRelation());
        }
        return static::$attendence_model = $model;
    }    

    public function showAttendence(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowAttendence($model);
        });
    }

    public function prepareStoreAttendence(AttendenceData $attendence_dto): Model{
        if (isset($attendence_dto->id)){
            $guard = ['id' => $attendence_dto->id];
        }else{
            $guard = [
                'employee_id' => $attendence_dto->employee_id,
                ''
            ];
        }

        $attendence = $this->attendence()->updateOrCreate([
            'id' => $attendence_dto->id
        ],[
            ''            
        ]);
        return static::$attendence_model = $attendence;
    }

    public function storeAttendence(? AttendenceData $attendence_dto = null): array{
        return $this->transaction(function () use ($attendence_dto) {
            return $this->showAttendence($this->prepareStoreAttendence($attendence_dto ?? $this->requestDTO(AttendenceData::class)));
        });
    }

    public function prepareViewAttendencePaginate(PaginateData $paginate_dto): LengthAwarePaginator{
        return $this->attendence()->with($this->viewUsingRelation())->paginate(...$paginate_dto->toArray())->appends(request()->all());
    }

    public function viewAttendencePaginate(? PaginateData $paginate_dto = null): array{
        return $this->viewEntityResource(function() use ($paginate_dto){            
            return $this->prepareViewAttendencePaginate($paginate_dto ?? $this->requestDTO(PaginateData::class));
        });
    }

    public function prepareViewAttendenceList(): Collection{
        return $this->attendence()->with($this->viewUsingRelation())->get();
    }

    public function viewAttendenceList(): array{
        return $this->viewEntityResource(function(){
            return $this->prepareViewAttendenceList();
        });
    }

    public function prepareDeleteAttendence(? array $attributes = null): bool{
        $attributes ??= request()->all();
        if (!isset($attributes['id'])) throw new \Exception('id not found');

        $attendence = $this->attendence()->findOrFail($attributes['id']);
        return $attendence->delete();
    }

    public function deleteAttendence(): bool{
        return $this->transaction(function(){
            return $this->prepareDeleteAttendence();
        });
    }

    public function attendence(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->AttendenceModel()->conditionals($this->mergeCondition($conditionals))->withParameters()->orderBy('created_at','desc');
    }
}

