<?php

namespace Hanafalah\ModuleEmployee\Resources\ModelHasEmployee;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewModelHasEmployee extends ApiResource
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'id' => $this->id,
            'employee' => $this->prop_employee,
            'model' => $this->prop_model,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
        return $arr;
    }
}
