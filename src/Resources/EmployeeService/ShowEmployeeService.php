<?php

namespace Hanafalah\ModuleEmployee\Resources\EmployeeService;

use Hanafalah\ModuleService\Resources\ShowService;

class ShowEmployeeService extends ViewEmployeeService
{

    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'price_components' => $this->relationValidation('priceComponents', function () {
                return $this->priceComponents->transform(function ($priceComponent) {
                    return $priceComponent->toShowApi()->resolve();
                });
            })
        ];
        $show = $this->resolveNow(new ShowService($this));
        $arr = array_merge(parent::toArray($request), $show, $arr);

        return $arr;
    }
}
