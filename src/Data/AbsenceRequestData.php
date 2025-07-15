<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\AbsenceRequestData as DataAbsenceRequestData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class AbsenceRequestData extends Data implements DataAbsenceRequestData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}