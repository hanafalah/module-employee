<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Hanafalah\ModuleEmployee\Contracts\Data\ShiftScheduleData;
//use Hanafalah\ModuleEmployee\Contracts\Data\ShiftScheduleUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleEmployee\Schemas\ShiftSchedule
 * @method mixed export(string $type)
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array updateShiftSchedule(?ShiftScheduleData $shift_schedule_dto = null)
 * @method Model prepareUpdateShiftSchedule(ShiftScheduleData $shift_schedule_dto)
 * @method bool deleteShiftSchedule()
 * @method bool prepareDeleteShiftSchedule(? array $attributes = null)
 * @method mixed getShiftSchedule()
 * @method ?Model prepareShowShiftSchedule(?Model $model = null, ?array $attributes = null)
 * @method array showShiftSchedule(?Model $model = null)
 * @method Collection prepareViewShiftScheduleList()
 * @method array viewShiftScheduleList()
 * @method LengthAwarePaginator prepareViewShiftSchedulePaginate(PaginateData $paginate_dto)
 * @method array viewShiftSchedulePaginate(?PaginateData $paginate_dto = null)
 * @method array storeShiftSchedule(?ShiftScheduleData $shift_schedule_dto = null);
 * @method Builder shiftSchedule(mixed $conditionals = null);
 */

interface ShiftSchedule extends EmployeeStuff
{
    public function prepareStoreShiftSchedule(ShiftScheduleData $shift_schedule_dto): Model;
}