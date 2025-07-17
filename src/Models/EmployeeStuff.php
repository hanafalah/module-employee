<?php

namespace Hanafalah\ModuleEmployee\Models;

use Hanafalah\LaravelSupport\Models\Unicode\Unicode;
use Hanafalah\ModuleEmployee\Resources\EmployeeStuff\{
    ViewEmployeeStuff,
    ShowEmployeeStuff
};

class EmployeeStuff extends Unicode
{
    protected $table = 'unicodes';

    public function getViewResource(){
        return ViewEmployeeStuff::class;
    }

    public function getShowResource(){
        return ShowEmployeeStuff::class;
    }
}
