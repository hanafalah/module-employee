<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Hanafalah\ModuleEmployee\Contracts\Data\ShiftData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface Shift extends DataManagement
{
    public function getShift(): mixed;
    public function prepareShowShift(?Model $model = null, ?array $attributes = null): Model;
    public function showShift(?Model $model = null): array;
    public function prepareStoreShift(ShiftData $attendence_dto): Model;
    public function storeShift(? ShiftData $attendence_dto = null): array;
    public function prepareViewShiftPaginate(PaginateData $paginate_dto): LengthAwarePaginator;
    public function viewShiftPaginate(? PaginateData $paginate_dto = null): array;
    public function prepareViewShiftList(): Collection;
    public function viewShiftList(): array;
    public function prepareDeleteShift(? array $attributes = null): bool;
    public function deleteShift(): bool;
    public function shiftMethod(mixed $conditionals = null): Builder;
    
    
}
