<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Illuminate\Database\Eloquent\{
    Builder,
    Collection,
    Model
};
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleEmployee\Contracts\Schemas\Shift as ContractsShift;
use Hanafalah\ModuleEmployee\Contracts\Data\ShiftData;
use Illuminate\Pagination\LengthAwarePaginator;

class Shift extends PackageManagement implements ContractsShift
{
    protected string $__entity = 'Shift';
    public static $shift_model;

    protected function viewUsingRelation(): array{
        return [];
    }

    protected function showUsingRelation(): array{
        return [
        ];
    }

    public function getShift(): mixed{
        return static::$shift_model;
    }

    public function prepareShowShift(?Model $model = null, ?array $attributes = null): Model{
        $attributes ??= request()->all();

        $model ??= $this->getShift();
        if (!isset($model)) {
            $id   = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('id not found');

            $model = $this->shiftMethod()->with($this->showUsingRelation())->findOrFail($id);            
        } else {
            $model->load($this->showUsingRelation());
        }
        return static::$shift_model = $model;
    }    

    public function showShift(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowShift($model);
        });
    }

    public function prepareStoreShift(ShiftData $shift_dto): Model{
        $shift = $this->shiftMethod()->updateOrCreate([
            'id' => $shift_dto->id ?? null
        ],[
            'name'       => $shift_dto->name,            
            'start_at'   => $shift_dto->start_at,
            'end_at'     => $shift_dto->end_at,
            'event_type' => $shift_dto->event_type ?? null, 
            'event_id'   => $shift_dto->event_id ?? null
        ]);
        return static::$shift_model = $shift;
    }

    public function storeShift(? ShiftData $shift_dto = null): array{
        return $this->transaction(function () use ($shift_dto) {
            return $this->showShift($this->prepareStoreShift($shift_dto ?? $this->requestDTO(ShiftData::class)));
        });
    }

    public function prepareViewShiftPaginate(PaginateData $paginate_dto): LengthAwarePaginator{
        return $this->shiftMethod()->with($this->viewUsingRelation())->paginate(...$paginate_dto->toArray())->appends(request()->all());
    }

    public function viewShiftPaginate(? PaginateData $paginate_dto = null): array{
        return $this->viewEntityResource(function() use ($paginate_dto){            
            return $this->prepareViewShiftPaginate($paginate_dto ?? $this->requestDTO(PaginateData::class));
        });
    }

    public function prepareViewShiftList(): Collection{
        return $this->shiftMethod()->with($this->viewUsingRelation())->get();
    }

    public function viewShiftList(): array{
        return $this->viewEntityResource(function(){
            return $this->prepareViewShiftList();
        });
    }

    public function prepareDeleteShift(? array $attributes = null): bool{
        $attributes ??= request()->all();
        if (!isset($attributes['id'])) throw new \Exception('id not found');

        $shift = $this->shiftMethod()->findOrFail($attributes['id']);
        return $shift->delete();
    }

    public function deleteShift(): bool{
        return $this->transaction(function(){
            return $this->prepareDeleteShift();
        });
    }

    public function shiftMethod(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->ShiftModel()->conditionals($this->mergeCondition($conditionals))->withParameters()->orderBy('name','asc');
    }
}

