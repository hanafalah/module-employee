<?php

namespace Zahzah\ModuleEmployee\Models\Employee;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Zahzah\LaravelHasProps\Concerns\HasProps;
use Zahzah\LaravelSupport\Models\BaseModel;
use Zahzah\ModuleCardIdentity\Concerns\HasCardIdentity;
use Zahzah\ModuleEmployee\Enums\Employee\EmployeeStatus;
use Zahzah\ModuleEmployee\Resources\Employee\ShowEmployee;
use Zahzah\ModuleEmployee\Resources\Employee\ViewEmployee;
use Zahzah\ModuleUser\Concerns\UserReference\HasUserReference;
use Zahzah\ModulePeople\Resources\People\ViewPeople;
use Zahzah\ModuleProfession\Concerns\Relation\HasProfession;

class Employee extends BaseModel
{
    use Notifiable, HasProps, HasProfession, 
        HasUserReference, SoftDeletes, HasCardIdentity;

    protected $list = ['id','people_id','status','props'];
    protected $show = ['sallary','profession_id'];

    protected $casts = [
        'name' => 'string'
    ];

    protected $prop_attributes = [
        'People' => ViewPeople::class
    ];

    public function getPropsQuery(): array{
        return [
            'name' => 'props->prop_people->name'
        ];
    }

    protected static function booted(): void{
        parent::booted();
        static::creating(function($query){
            if (!isset($query->status)) $query->status = EmployeeStatus::DRAFT->value;
        });
    }

    public function toShowApi(){
        return new ShowEmployee($this);
    }

    public function toViewApi(){
        return new ViewEmployee($this);
    }

    public function people(){return $this->belongsToModel('People');}
    public function employeeService(){return $this->morphOneModel('EmployeeService','reference');}
    public function employeeServices(){return $this->morphManyModel('EmployeeService','reference');}

    //END EIGER SECTION
}
