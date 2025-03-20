<?php

namespace Zahzah\ModuleEmployee\Resources\Employee;

use Zahzah\ModulePeople\Resources\People\ShowPeople;

class ShowEmployee extends ViewEmployee
{

    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'hired_at'   => $this->hired_at,
            'people'     => $this->relationValidation('people',function(){
                return $this->people->toShowApi();
            }),
            'employee_service' => $this->relationValidation('employeeService',function(){
                return $this->employeeService->toShowApi();
            }),
            'profession' => $this->relationValidation('profession',function(){
                $profession = $this->profession;
                return [
                    'id'   => $profession->getKey(),
                    'name' => $profession->name
                ];
            }),
            'card_identities' => $this->relationValidation('cardIdentities',function(){
                $cardIdentities = $this->cardIdentities;
                return $cardIdentities->isEmpty() ? null : (object) $cardIdentities->mapWithKeys(function($cardIdentity) {
                    return [\strtoupper($cardIdentity->flag) => $cardIdentity->value];
                });
            },true)
        ];

        $arr = array_merge(parent::toArray($request),$arr);
        
        return $arr;
    }
}

