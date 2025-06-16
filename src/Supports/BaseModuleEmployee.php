<?php

namespace Hanafalah\ModuleEmployee\Supports;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\LaravelSupport\Supports\PackageManagement;

class BaseModuleEmployee extends PackageManagement implements DataManagement
{
    protected $__config_name = 'module-employee';
    protected $__module_employee_config = [];

    /**
     * A description of the entire PHP function.
     *
     * @param Container $app The Container instance
     * @throws Exception description of exception
     * @return void
     */
    public function __construct()
    {
        $this->setConfig($this->__config_name, $this->__module_employee_config);
    }
}
