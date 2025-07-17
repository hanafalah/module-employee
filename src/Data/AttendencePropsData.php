<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\AttendencePropsData as DataAttendencePropsData;
use Hanafalah\ModuleEmployee\Contracts\Data\SummaryData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class AttendencePropsData extends Data implements DataAttendencePropsData{
    #[MapInputName('summary')]
    #[MapName('summary')]
    public ?SummaryData $summary = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
    
    public static function after(self $data): self{
        return $data;
    }
}