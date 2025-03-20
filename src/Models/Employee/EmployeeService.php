<?php

namespace Zahzah\ModuleEmployee\Models\Employee;

use Gii\ModuleService\Models\Service;
use Zahzah\ModuleEmployee\Resources\EmployeeService\{
    ViewEmployeeService, ShowEmployeeService
};

class EmployeeService extends Service
{
    protected $table = 'services';

    public function toViewApi(){
        return new ViewEmployeeService($this);
    }

    public function toShowApi(){
        return new ShowEmployeeService($this);
    }
}
