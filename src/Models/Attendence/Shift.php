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
        'id', 'name','event_type', 'event_id', 'start_at', 'end_at', 'props'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime'
    ];

    public function getViewResource(){
        return ViewShift::class;
    }

    public function getShowResource(){
        return ShowShift::class;
    }

    public function event(){return $this->morphTo();}
}