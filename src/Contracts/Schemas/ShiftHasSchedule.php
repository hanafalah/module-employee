<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Hanafalah\ModuleEmployee\Contracts\Data\ShiftHasScheduleData;
//use Hanafalah\ModuleEmployee\Contracts\Data\ShiftHasScheduleUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleEmployee\Schemas\ShiftHasSchedule
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateShiftHasSchedule(?ShiftHasScheduleData $shift_has_schedule_dto = null)
 * @method Model prepareUpdateShiftHasSchedule(ShiftHasScheduleData $shift_has_schedule_dto)
 * @method bool deleteShiftHasSchedule()
 * @method bool prepareDeleteShiftHasSchedule(? array $attributes = null)
 * @method mixed getShiftHasSchedule()
 * @method ?Model prepareShowShiftHasSchedule(?Model $model = null, ?array $attributes = null)
 * @method array showShiftHasSchedule(?Model $model = null)
 * @method Collection prepareViewShiftHasScheduleList()
 * @method array viewShiftHasScheduleList()
 * @method LengthAwarePaginator prepareViewShiftHasSchedulePaginate(PaginateData $paginate_dto)
 * @method array viewShiftHasSchedulePaginate(?PaginateData $paginate_dto = null)
 * @method array storeShiftHasSchedule(?ShiftHasScheduleData $shift_has_schedule_dto = null);
 * @method Collection prepareStoreMultipleShiftHasSchedule(array $datas)
 * @method array storeMultipleShiftHasSchedule(array $datas)

 * @method Builder shiftHasSchedule(mixed $conditionals = null);
 */

interface ShiftHasSchedule extends DataManagement
{
    public function prepareStoreShiftHasSchedule(ShiftHasScheduleData $shift_has_schedule_dto): Model;
}