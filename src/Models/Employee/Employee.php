<?php

namespace Hanafalah\ModuleEmployee\Models\Employee;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleCardIdentity\Concerns\HasCardIdentity;
use Hanafalah\ModuleEmployee\Enums\Employee\EmployeeStatus;
use Hanafalah\ModuleEmployee\Resources\Employee\ShowEmployee;
use Hanafalah\ModuleEmployee\Resources\Employee\ViewEmployee;
use Hanafalah\ModuleUser\Concerns\UserReference\HasUserReference;
use Hanafalah\ModulePeople\Resources\People\ViewPeople;
use Hanafalah\ModuleProfession\Concerns\Relation\HasProfession;

class Employee extends BaseModel
{
    use Notifiable,
        HasProps,
        HasProfession,
        HasUserReference,
        SoftDeletes,
        HasCardIdentity;

    protected $list = ['id', 'people_id', 'status', 'props'];
    protected $show = ['sallary', 'profession_id'];

    protected $casts = [
        'name' => 'string'
    ];

    protected $prop_attributes = [
        'People' => ViewPeople::class
    ];

    public function getPropsQuery(): array
    {
        return [
            'name' => 'props->prop_people->name'
        ];
    }

    protected static function booted(): void
    {
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->status)) $query->status = EmployeeStatus::DRAFT->value;
        });
    }

    public function toShowApi()
    {
        return new ShowEmployee($this);
    }

    public function toViewApi()
    {
        return new ViewEmployee($this);
    }

    public function people()
    {
        return $this->belongsToModel('People');
    }
    public function employeeService()
    {
        return $this->morphOneModel('EmployeeService', 'reference');
    }
    public function employeeServices()
    {
        return $this->morphManyModel('EmployeeService', 'reference');
    }

    //END EIGER SECTION
}
