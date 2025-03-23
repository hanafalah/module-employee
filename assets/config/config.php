<?php

use Hanafalah\ModuleEmployee\{
    Models as ModuleEmployeeModels,
    Commands as ModuleEmployeeCommands,
    Contracts
};

return [
    'app' => [
        'contracts' => [
            'employee'         => Contracts\Employee::class,
            'employee_service' => Contracts\EmployeeService::class,
            'module_employee'  => Contracts\ModuleEmployee::class
        ],
    ],
    'commands' => [
        ModuleEmployeeCommands\InstallMakeCommand::class
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts'
    ],
    'database' => [
        'models' => [
            'Employee'        => ModuleEmployeeModels\Employee\Employee::class,
            'EmployeeService' => ModuleEmployeeModels\Employee\EmployeeService::class
        ]
    ]
];
