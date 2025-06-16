<?php

namespace Hanafalah\ModuleEmployee\Models\EmployeeType;

use Hanafalah\LaravelHasProps\Concerns\HasCurrent;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeHasType extends BaseModel{
    use HasUlids, SoftDeletes, HasCurrent;
    
    public $incrementing  = false;
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    protected $list = [
        'id', 'employee_id', 'employee_type_id', 'current'
    ];

    public $current_conditions = [
        'employee_id'
    ];
    
    public function employee(){$this->belongsToModel('employee_id');}
    public function employeeType(){$this->belongsToModel('employee_type_id');}
}