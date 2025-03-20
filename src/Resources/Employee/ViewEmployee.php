<?php

namespace Hanafalah\ModuleEmployee\Resources\Employee;

use Hanafalah\LaravelSupport\Resources\ApiResource;
use Hanafalah\ModulePeople\Resources\People\ViewPeople;

class ViewEmployee extends ApiResource
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'id'               => $this->id,
            'people'           => $this->propResource($this->people, ViewPeople::class, ['id']),
            'status'           => $this->status,
            'profile'          => $this->profile ?? null,
            'employee_service' => $this->relationValidation('employeeService', function () {
                return $this->employeeService->toViewApi();
            }),
            'user_reference'   => $this->relationValidation('userReference', function () {
                $userReference = $this->userReference;
                return $userReference->toShowApi();
            }),
            'profession'     => $this->relationValidation('profession', function () {
                $profession = $this->profession;
                return $profession->toShowApi();
            })
        ];

        return $arr;
    }
}
