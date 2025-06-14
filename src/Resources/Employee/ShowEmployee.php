<?php

namespace Hanafalah\ModuleEmployee\Resources\Employee;

use Illuminate\Support\Str;

class ShowEmployee extends ViewEmployee
{

    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'occupation' => $this->relationValidation('occupation', function () {
                return $this->occupation->toViewApi();
            },$this->prop_occupation),
            'people'     => $this->relationValidation('people', function () {
                return $this->people->toShowApi();
            }),
            'employee_service' => $this->relationValidation('employeeService', function () {
                return $this->employeeService->toShowApi();
            }),
            'user_reference'   => $this->relationValidation('userReference', function () {
                return $this->userReference->toShowApi();
            }),
            'card_identities' => $this->relationValidation('cardIdentities', function () {
                $cardIdentities = $this->cardIdentities;
                return $cardIdentities->isEmpty() ? null : (object) $cardIdentities->mapWithKeys(function ($cardIdentity) {
                    return [Str::lower($cardIdentity->flag) => $cardIdentity->value];
                });
            })
        ];

        $arr = array_merge(parent::toArray($request), $arr);

        return $arr;
    }
}
