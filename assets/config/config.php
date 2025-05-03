<?php

use Hanafalah\ModuleEmployee\{
    Models as ModuleEmployeeModels,
    Commands as ModuleEmployeeCommands,
    Contracts
};

return [
    'namespace' => 'Hanafalah\\ModuleEmployee',
    'app' => [
        'contracts' => [
            //ADD YOUR CONTRACTS HERE
        ]
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations'
    ],
    'database' => [
        'models' => [
            // ADD YOUR MODELS HERE
            ]
    ],
    'commands' => [
        ModuleEmployeeCommands\InstallMakeCommand::class
    ]
];
