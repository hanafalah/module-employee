<?php

namespace Hanafalah\ModuleEmployee\Resources\EmployeeType;

class ShowEmployeeType extends ViewEmployeeType
{

    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
        ];
        $arr = array_merge(parent::toArray($request), $arr);
        return $arr;
    }
}
