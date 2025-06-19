<?php

namespace Hanafalah\ModuleEmployee\Resources\Employee;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewEmployee extends ApiResource
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'id'               => $this->id,
            'uuid'             => $this->uuid,
            'name'             => $this->name,
            'hired_at'         => $this->hired_at,
            'card_identity'    => $this->prop_card_identity,
            'people'           => $this->prop_people,
            'status'           => $this->status,
            'profile'          => $this->profile ?? null,
            'sign'             => $this->sign ?? null,
            'employee_service' => $this->relationValidation('employeeService', function () {
                return $this->employeeService->toViewApi();
            }),            
            'profession'       => $this->prop_profession,
            'occupation'       => $this->prop_occupation,
            'created_at'       => $this->created_at,
            'updated_at'       => $this->updated_at
        ];

        return $arr;
    }
}
