<?php

namespace Hanafalah\ModuleEmployee\Models\Attendence;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleEmployee\Resources\Shift\{
    ViewShift, ShowShift
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends BaseModel{
    use HasUlids, SoftDeletes, HasProps;

    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    protected $list       = [
        'id', 'name', 'employee_type', 'employee_id', 'event_type', 'event_id', 'off_days', 'props'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime'
    ];

    public function viewUsingRelation(): array{
        return ['shiftSchedules'];
    }

    public function showUsingRelation(): array{
        return ['shiftSchedules'];
    }

    public function getViewResource(){
        return ViewShift::class;
    }

    public function getShowResource(){
        return ShowShift::class;
    }

    public function employee(){return $this->morphTo();}
    public function shiftSchedules(){
        return $this->belongsToManyModel(
            'ShiftSchedule',
            'ShiftHasSchedule',
            'shift_id',
            'shift_schedule_id'
        );
    }
    public function event(){return $this->morphTo();}
}