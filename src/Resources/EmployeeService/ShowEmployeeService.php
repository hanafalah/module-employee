<?php

namespace Hanafalah\ModuleEmployee\Resources\EmployeeService;

use Hanafalah\ModuleService\Resources\ShowService;

class ShowEmployeeService extends ViewEmployeeService
{

    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [

        ];
        $show = $this->resolveNow(new ShowService($this));
        $arr = $this->mergeArray(parent::toArray($request), $show, $arr);
        return $arr;
    }
}
