<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeStuffData as DataEmployeeStuffData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class EmployeeStuffData extends Data implements DataEmployeeStuffData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('flag')]
    #[MapName('flag')]
    public string $flag;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}