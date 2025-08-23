<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeServiceData;
use Hanafalah\ModuleService\Schemas\Service;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleEmployee\Contracts\Schemas\EmployeeService as ContractsEmployeeService;
use Illuminate\Database\Eloquent\Builder;

class EmployeeService extends Service implements ContractsEmployeeService
{
    protected string $__entity = 'EmployeeService';
    public $employee_service_model;

    public function prepareStoreEmployeeService(?EmployeeServiceData $employee_service_dto): Model{
        $employee_service = $this->prepareStoreService($employee_service_dto);
        return $this->employee_service_model = $employee_service;
    }

    public function employeeService(mixed $conditionals): Builder{
        return $this->service($conditionals);
    }
}
