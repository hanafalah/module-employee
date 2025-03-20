<?php

declare(strict_types=1);

namespace Zahzah\ModuleEmployee;

use Zahzah\LaravelSupport\Providers\BaseServiceProvider;

class ModuleEmployeeServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     * 
     * @return $this
     */
    public function register()
    {
        $this->registerMainClass(ModuleEmployee::class)
             ->registerCommandService(Providers\CommandServiceProvider::class)
             ->registers([
                '*','Services' => function(){
                    $this->binds([
                        Contracts\ModuleEmployee::class => new ModuleEmployee,
                        Contracts\Employee::class => new Schemas\Employee,
                        Contracts\EmployeeService::class => new Schemas\EmployeeService
                    ]);
                }
            ]);
    }

    /**
     * Get the base path of the package.
     *
     * @return string
     */
    protected function dir(): string{
        return __DIR__.'/';
    }

    protected function migrationPath(string $path = ''): string{
        return database_path($path);
    }
}
