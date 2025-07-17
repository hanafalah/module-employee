<?php

namespace Hanafalah\ModuleEmployee\Models\Attendence;

use Hanafalah\ModuleEmployee\Models\EmployeeStuff;
use Hanafalah\ModuleEmployee\Resources\ShiftSchedule\{
    ViewShiftSchedule,
    ShowShiftSchedule
};

class ShiftSchedule extends EmployeeStuff
{
    protected $table = 'unicodes';
    
    protected $casts = [
        'name'     => 'string',
        'flag'     => 'string',
        'start_at' => 'string',
        'end_at'   => 'string',
    ];

    public function getViewResource(){
        return ViewShiftSchedule::class;
    }

    public function getShowResource(){
        return ShowShiftSchedule::class;
    }
}
