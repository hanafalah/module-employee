<?php

declare(strict_types=1);

namespace Hanafalah\ModuleEmployee;

use Hanafalah\LaravelSupport\Providers\BaseServiceProvider;

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
                '*',
                'Services' => function(){
                    $this->binds([
                        Contracts\Schemas\ProfileEmployee::class => Schemas\Employee::class,
                        Contracts\Schemas\ProfilePhoto::class => Schemas\Employee::class
                    ]);
                }
            ]);
    }
    

    /**
     * Get the base path of the package.
     *
     * @return string
     */
    protected function dir(): string
    {
        return __DIR__ . '/';
    }

    protected function migrationPath(string $path = ''): string
    {
        return database_path($path);
    }
}
