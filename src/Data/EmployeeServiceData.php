<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeServiceData as DataEmployeeServiceData;
use Hanafalah\ModuleService\Data\ServiceData;
use Hanafalah\ModuleService\Data\ServicePriceData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class EmployeeServiceData extends ServiceData implements DataEmployeeServiceData{
    #[MapInputName('flag')]
    #[MapName('flag')]
    public ?string $flag = null;

    #[MapInputName('service_prices')]
    #[MapName('service_prices')]
    #[DataCollectionOf(ServicePriceData::class)]
    public ?array $service_prices = null;
}