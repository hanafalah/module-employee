<?php

namespace Hanafalah\ModuleEmployee\Models\Attendence;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModuleEmployee\Resources\AbsenceRequest\{
    ViewAbsenceRequest,
    ShowAbsenceRequest
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class AbsenceRequest extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'employee_id', 'absence_type',
        'total_day', 'start_at', 'end_at',
        'reason', 'status', 'approver_type', 
        'approver_id', 'approved_at','props',
    ];

    protected $casts = [
        'name' => 'string',
        'total_day' => 'integer',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'reason' => 'string',
        'status' => 'string',
        'approver_type' => 'string'
    ];
    

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return ['employee'];
    }

    public function getViewResource(){
        return ViewAbsenceRequest::class;
    }

    public function getShowResource(){
        return ShowAbsenceRequest::class;
    }

    public function employee(){return $this->belongsToModel('Employee');}    
    public function approver(){return $this->morphTo();}
    
}
