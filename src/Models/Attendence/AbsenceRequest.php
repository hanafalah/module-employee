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
    
    const ABSENCE_TYPE_MATERNITY_LEAVE = 'MATERNITY_LEAVE';
    const ABSENCE_TYPE_ANNUAL_LEAVE = 'ANNUAL_LEAVE';
    const ABSENCE_TYPE_SICK = 'SICK';
    const ABSENCE_TYPE_LEAVE = 'PERMISSION';
    const ABSENCE_TYPE_OTHER = 'OTHER';
    

    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'employee_id', 'absence_type',
        'total_day', 'reason', 'status', 'approver_type', 
        'approver_id', 'approved_at','props',
    ];

    protected $casts = [
        'total_day' => 'integer',
        'reason' => 'string',
        'status' => 'string',
        'approver_type' => 'string'
    ];
    
    protected static function booted(): void{
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->status)) $query->status = 'DRAFT';
        });
    }

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
