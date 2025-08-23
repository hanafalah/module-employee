<?php

namespace Hanafalah\ModuleEmployee\Resources\EmployeeService;

use Hanafalah\ModuleService\Resources\ViewService;

class ViewEmployeeService extends ViewService
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [];
        $arr = $this->mergeArray(parent::toArray($request), $arr);
        return $arr;
    }
}
