<?php

namespace Hanafalah\ModuleEmployee\Models\Attendence;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendence extends BaseModel{
    use HasUlids, SoftDeletes, HasProps;

    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    protected $list       = [
        'id', 'employee_id', 'shift_id', 'check_in', 'check_out',
        'status', 'props'
    ];
    protected $show       = [
        'author_type', 'author_id'
    ];

    protected $casts = [
        'check_in'  => 'datetime',
        'check_out' => 'datetime',
        'status'    => 'string',
        'name'      => 'string'
    ];

    public function getPropsQuery(): array
    {
        return [
            'name' => 'props->prop_employee->prop_people->name'
        ];
    }

    public function employee(){return $this->belongsToModel('Employee');}
    public function author(){return $this->morphTo();}
    public function shift(){return $this->belongsToModel('shift');}
}