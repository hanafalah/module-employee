<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Hanafalah\LaravelSupport\Schemas\Unicode;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleEmployee\Contracts\Schemas\EmployeeStuff as ContractsEmployeeStuff;
use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeStuffData;
use Illuminate\Database\Eloquent\Builder;

class EmployeeStuff extends Unicode implements ContractsEmployeeStuff
{
    protected string $__entity = 'EmployeeStuff';
    protected $__config_name = 'module-employee';
    public static $employee_stuff_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'employee_stuff',
            'tags'     => ['employee_stuff', 'employee_stuff-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreEmployeeStuff(EmployeeStuffData $employee_stuff_dto): Model{
        $employee_stuff = $this->prepareStoreUnicode($employee_stuff_dto);
        return static::$employee_stuff_model = $employee_stuff;
    }

    public function employeeStuff(mixed $conditionals = null): Builder{
        return $this->unicode($conditionals);
    }
}