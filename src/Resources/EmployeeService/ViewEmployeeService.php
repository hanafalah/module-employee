<?php

namespace Zahzah\ModuleEmployee\Resources\EmployeeService;

use Gii\ModuleService\Resources\ViewService;

class ViewEmployeeService extends ViewService
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            
        ];
        $arr = array_merge(parent::toArray($request),$arr);
        
        return $arr;
    }

}

