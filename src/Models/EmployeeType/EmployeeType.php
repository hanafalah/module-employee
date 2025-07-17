<?php

namespace Hanafalah\ModuleEmployee\Models\EmployeeType;

use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleEmployee\Resources\EmployeeType\{ViewEmployeeType, ShowEmployeeType};
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeType extends BaseModel{
    use SoftDeletes, HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $list = [
        'id', 'name', 'note'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public function getViewResource(){
        return ViewEmployeeType::class;
    }

    public function getShowResource(){
        return ShowEmployeeType::class;
    }

    public function employeeHasType(){return $this->belongsToModel('EmployeeHasType');}
    public function employee(){return $this->belongsToModel('Employee');}
}