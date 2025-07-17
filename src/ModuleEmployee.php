<?php

namespace Hanafalah\ModuleEmployee;

use Hanafalah\LaravelSupport\Supports\PackageManagement;

class ModuleEmployee extends PackageManagement implements Contracts\ModuleEmployee
{
    /** @var array */
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
        $this->setConfig('module-employee', $this->__module_employee_config);
    }
}
