<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\AbsenceRequestPropsData as DataAbsenceRequestPropsData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class AbsenceRequestPropsData extends Data implements DataAbsenceRequestPropsData{
    #[MapInputName('dates')]
    #[MapName('dates')]
    public ?array $dates = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
    
    public static function after(self $data): self{
        return $data;
    }
}