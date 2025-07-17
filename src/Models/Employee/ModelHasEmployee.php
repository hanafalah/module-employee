<?php

namespace Hanafalah\ModuleEmployee\Models\Employee;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleEmployee\Resources\ModelHasEmployee\{ShowModelHasEmployee, ViewModelHasEmployee};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ModelHasEmployee extends BaseModel
{
    use HasUlids, HasProps;

    public $incrementing  = false;
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    protected $list       = ['id', 'model_type', 'model_id', 'employee_id', 'props'];
    protected $show       = [];

    protected $casts = [
        'model_name' => 'string',
        'employee_name' => 'string'
    ]; 

    public function getPropsQuery(): array{
        return [
            'model_name' => 'props->prop_model->name',
            'employee_name' => 'props->prop_employee->name'
        ];
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getShowResource(){
        return ShowModelHasEmployee::class;
    }

    public function getViewResource(){
        return ViewModelHasEmployee::class;
    }

    public function model(){return $this->morphTo();}
    public function employee(){return $this->belongsToModel('Employee');}
}
