<?php

namespace Hanafalah\ModuleEmployee\Models\Attendence;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeShift extends BaseModel{
    use HasUlids, SoftDeletes, HasProps;

    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    protected $list       = [
        'id', 'employee_id', 'shift_id', 'shift_date', 'props'
    ];

    protected $casts = [
        'shift_date' => 'date'
    ];

    public function employee(){return $this->belongsToModel('Employee');}
    public function event(){return $this->morphTo();}
}