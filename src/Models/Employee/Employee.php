<?php

namespace Hanafalah\ModuleEmployee\Models\Employee;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Concerns\Support\HasProfilePhoto;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleCardIdentity\Concerns\HasCardIdentity;
use Hanafalah\ModuleEmployee\Concerns\HasAccessAttendence;
use Hanafalah\ModuleEmployee\Enums\Employee\EmployeeStatus;
use Hanafalah\ModuleEmployee\Resources\Employee\ShowEmployee;
use Hanafalah\ModuleEmployee\Resources\Employee\ViewEmployee;
use Hanafalah\ModuleProfession\Concerns\Relation\HasOccupation;
use Hanafalah\ModuleUser\Concerns\UserReference\HasUserReference;
use Hanafalah\ModuleProfession\Concerns\Relation\HasProfession;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Employee extends BaseModel
{
    use HasUlids, Notifiable, HasProps, HasProfession, HasOccupation,
        HasUserReference, SoftDeletes,
        HasCardIdentity, HasProfilePhoto,
        HasAccessAttendence;

    public $incrementing  = false;
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    protected $list       = ['id', 'uuid', 'people_id', 'status', 'profile', 'props'];
    protected $show       = ['sallary', 'employee_type_id', 'profession_id', 'occupation_id'];

    protected $casts = [
        'name' => 'string',
        'uuid' => 'string',
        'occupation_name' => 'string',
        'profession_name' => 'string',
        'employee_type_name' => 'string',
    ]; 

    protected $prop_attributes = [
        'People' => [
            'name','first_name','last_name','nik','sex',
            'dob','pob'
        ]
    ];

    public function getPropsQuery(): array{
        return [
            'name' => 'props->prop_people->name',
            'uuid' => 'props->uuid',
            'occupation_name' => 'props->prop_occupation->name',
            'profession_name' => 'props->prop_profession->name',
            'employee_type_name' => 'props->prop_employee_type->name'
        ];
    }

    protected static function booted(): void{
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->status)) $query->status = EmployeeStatus::DRAFT->value;
        });
    }

    public function viewUsingRelation(): array{
        return ['people.cardIdentities'];
    }

    public function showUsingRelation(): array{
        return [
            'people'        => fn($q) => $q->with(['addresses', 'cardIdentities']),
            'userReference' => fn($q) => $q->with(['roles', 'user'])
        ];
    }

    public function getShowResource(){
        return ShowEmployee::class;
    }

    public function getViewResource(){
        return ViewEmployee::class;
    }

    public function people(){
        return $this->belongsToModel('People');
    }
    public function employeeService(){
        return $this->morphOneModel('EmployeeService', 'reference');
    }

    public function employeeServices(){
        return $this->morphManyModel('EmployeeService', 'reference');
    }

    public function employeeType(){
        return $this->belongsToModel('EmployeeType');
    }
    public function attendence(){return $this->hasOneModel('Attendence');}
    public function attendences(){return $this->hasManyModel('Attendence');}
}
