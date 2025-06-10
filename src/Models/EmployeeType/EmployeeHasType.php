<?php

namespace Hanafalah\ModuleEmployee\Models\EmployeeType;

use Hanafalah\LaravelHasProps\Concerns\HasCurrent;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeHasType extends BaseModel{
    use SoftDeletes, HasCurrent;
    
    protected $list = [
        'id', 'employee_id', 'employee_type_id', 'current'
    ];

    public $current_conditions = [
        'employee_id'
    ];
    
    public function employee(){$this->belongsToModel('employee_id');}
    public function employeeType(){$this->belongsToModel('employee_type_id');}
}