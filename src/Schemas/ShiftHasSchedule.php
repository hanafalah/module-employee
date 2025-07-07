<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleEmployee\{
    Supports\BaseModuleEmployee
};
use Hanafalah\ModuleEmployee\Contracts\Schemas\ShiftHasSchedule as ContractsShiftHasSchedule;
use Hanafalah\ModuleEmployee\Contracts\Data\ShiftHasScheduleData;

class ShiftHasSchedule extends BaseModuleEmployee implements ContractsShiftHasSchedule
{
    protected string $__entity = 'ShiftHasSchedule';
    public static $shift_has_schedule_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'shift_has_schedule',
            'tags'     => ['shift_has_schedule', 'shift_has_schedule-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreShiftHasSchedule(ShiftHasScheduleData $shift_has_schedule_dto): Model{
        if (isset($shift_has_schedule_dto->shift_schedule) && !isset($shift_has_schedule_dto->shift_schedule_id)) {
            $shift_schedule_model = $this->schemaContract('shift_schedule')->prepareStoreShiftSchedule($shift_has_schedule_dto->shift_schedule);
            $shift_has_schedule_dto->shift_schedule_id = $shift_schedule_model->id;
            $shift_has_schedule_dto->props['prop_shift_schedule'] = [
                'id'       => $shift_schedule_model->getKey(),
                'name'     => $shift_schedule_model->name,
                'start_at' => $shift_schedule_model->start_at,
                'end_at'   => $shift_schedule_model->end_at
            ];
        }
        $add = [
            'shift_id'          => $shift_has_schedule_dto->shift_id,
            'shift_schedule_id' => $shift_has_schedule_dto->shift_schedule_id,
        ];
        if (isset($shift_has_schedule_dto->id)){
            $guard  = ['id' => $shift_has_schedule_dto->id];
            $create = [$guard, $add];
        }else{
            $create = [$add];
        }

        $shift_has_schedule = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($shift_has_schedule,$shift_has_schedule_dto->props);
        $shift_has_schedule->save();
        $this->forgetTagsEntity();
        return static::$shift_has_schedule_model = $shift_has_schedule;
    }
}