<?php

namespace Hanafalah\ModuleEmployee\Models\Attendence;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModuleEmployee\Resources\ShiftHasSchedule\{
    ViewShiftHasSchedule,
    ShowShiftHasSchedule
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ShiftHasSchedule extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id',
        'shift_id',
        'shift_schedule_id',
        'props',
    ];

    protected $casts = [
        'name' => 'string'
    ];

    protected $prop_attributes = [
        'ShiftSchedule' => [
            'id','name','start_at','end_at'
        ]
    ];

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewShiftHasSchedule::class;
    }

    public function getShowResource(){
        return ShowShiftHasSchedule::class;
    }

    
    public function shift(){return $this->belongsToModel('Shift');}
    public function shiftSchedule(){return $this->belongsToModel('ShiftSchedule');}
}
