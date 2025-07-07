<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Data\UnicodeData;
use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeStuffData as DataEmployeeStuffData;

class EmployeeStuffData extends UnicodeData implements DataEmployeeStuffData
{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'EmployeeStuff';
        parent::before($attributes);
    }
}