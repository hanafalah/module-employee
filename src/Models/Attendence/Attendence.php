<?php

namespace Hanafalah\ModuleEmployee\Models\Attendence;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Concerns\Support\HasFileUpload;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleEmployee\Resources\Attendence\ShowAttendence;
use Hanafalah\ModuleEmployee\Resources\Attendence\ViewAttendence;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendence extends BaseModel{
    use HasUlids, SoftDeletes, HasProps, HasFileUpload;

    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    protected $list       = [
        'id', 'employee_id', 'shift_id', 'check_in', 'check_out',
        'absence_request_id', 'status', 'props'
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
            'name' => 'props->prop_employee->name'
        ];
    }

    protected static function booted(): void{
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->status)) $query->status = 'DRAFT';
        });
    }

    public function getViewResource(){return ViewAttendence::class;}
    public function getShowResource(){return ShowAttendence::class;}

    public function employee(){return $this->belongsToModel('Employee');}
    public function author(){return $this->morphTo();}
    public function shift(){return $this->belongsToModel('Shift');}
    public function absenceRequest(){return $this->belongsToModel('AbsenceRequest');}
}