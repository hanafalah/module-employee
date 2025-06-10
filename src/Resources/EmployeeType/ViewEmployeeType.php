<?php

namespace Hanafalah\ModuleEmployee\Resources\EmployeeType;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewEmployeeType extends ApiResource
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'id'   => $this->id,
            'name' => $this->name,
            'note' => $this->note
        ];
        return $arr;
    }
}
