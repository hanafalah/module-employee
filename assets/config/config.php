<?php 

use Zahzah\ModuleEmployee\{
    Models as ModuleEmployeeModels,
    Commands as ModuleEmployeeCommands,
    Contracts
};

return [
    'contracts' => [
        'employee'         => Contracts\Employee::class,
        'employee_service' => Contracts\EmployeeService::class,
        'module_employee'  => Contracts\ModuleEmployee::class
    ],
    'commands' => [
        ModuleEmployeeCommands\InstallMakeCommand::class
    ],
    'database' => [
        'models' => [
            'Employee'        => ModuleEmployeeModels\Employee\Employee::class,
            'EmployeeService' => ModuleEmployeeModels\Employee\EmployeeService::class
        ]
    ]
];