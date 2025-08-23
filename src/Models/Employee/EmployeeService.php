<?php

namespace Hanafalah\ModuleEmployee\Models\Employee;

use Hanafalah\ModuleService\Models\Service;
use Hanafalah\ModuleEmployee\Resources\EmployeeService\{
    ViewEmployeeService,
    ShowEmployeeService
};

class EmployeeService extends Service
{
    protected $table = 'services';

    public function getViewResource(){return ViewEmployeeService::class;}
    public function getShowResource(){return ShowEmployeeService::class;}
}
