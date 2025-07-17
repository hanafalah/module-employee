<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Hanafalah\ModuleEmployee\Contracts\Data\ShiftData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @see \Hanafalah\ModuleEmployee\Schemas\Shift
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method mixed export(string $type)
 * @method bool deleteShift()
 * @method bool prepareDeleteShift(? array $attributes = null)
 * @method mixed getShift()
 * @method ?Model prepareShowShift(?Model $model = null, ?array $attributes = null)
 * @method array showShift(?Model $model = null)
 * @method Collection prepareViewShiftList()
 * @method array viewShiftList()
 * @method LengthAwarePaginator prepareViewShiftPaginate(PaginateData $paginate_dto)
 * @method array viewShiftPaginate(?PaginateData $paginate_dto = null)
 * @method array storeShift(?ShiftData $shift_dto = null)
 * @method Builder shift(mixed $conditionals = null)
 */
interface Shift extends DataManagement
{
    public function prepareStoreShift(ShiftData $attendence_dto): Model;
}
