<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleEmployee\Contracts\Schemas\ShiftSchedule as ContractsShiftSchedule;
use Hanafalah\ModuleEmployee\Contracts\Data\ShiftScheduleData;

class ShiftSchedule extends EmployeeStuff implements ContractsShiftSchedule
{
    protected string $__entity = 'ShiftSchedule';
    public static $shift_schedule_model;
    protected mixed $__order_by_created_at = false;

    protected array $__cache = [
        'index' => [
            'name'     => 'shift_schedule',
            'tags'     => ['shift_schedule', 'shift_schedule-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreShiftSchedule(ShiftScheduleData $shift_schedule_dto): Model{
        $shift_schedule = parent::prepareStoreEmployeeStuff($shift_schedule_dto);
        $this->forgetTagsEntity();
        return static::$shift_schedule_model = $shift_schedule;
    }
}