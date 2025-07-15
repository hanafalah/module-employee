<?php

namespace Hanafalah\ModuleEmployee\Models\Attendence;

use Hanafalah\LaravelHasProps\Concerns\HasCurrent;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModuleEmployee\Resources\AttendenceSummary\{
    ViewAttendenceSummary,
    ShowAttendenceSummary
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class AttendenceSummary extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, HasCurrent;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id',
        'employee_id',
        'period_flag',
        'current',
        'props'
    ];

    protected $casts = [
        'name' => 'string'
    ];
    

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewAttendenceSummary::class;
    }

    public function getShowResource(){
        return ShowAttendenceSummary::class;
    }

    public function employee(){return $this->belongsToModel('Employee');}
}
