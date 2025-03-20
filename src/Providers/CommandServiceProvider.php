<?php

declare(strict_types=1);

namespace Zahzah\ModuleEmployee\Providers;

use Illuminate\Support\ServiceProvider;
use Zahzah\ModuleEmployee\Commands;

class CommandServiceProvider extends ServiceProvider
{
    private $commands = [
        Commands\InstallMakeCommand::class,
    ];


    public function register(){
        $this->commands(config('module-employee.commands',$this->commands));
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */

    public function provides()
    {
        return $this->commands;
    }
}
