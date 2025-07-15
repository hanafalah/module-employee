<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\AttendenceSummaryData as DataAttendenceSummaryData;
use Hanafalah\ModuleEmployee\Contracts\Data\SummaryData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class AttendenceSummaryData extends Data implements DataAttendenceSummaryData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public string $id;

    #[MapInputName('employee_id')]
    #[MapName('employee_id')]
    public string $employee_id;

    #[MapInputName('period_flag')]
    #[MapName('period_flag')]
    public ?string $period_flag = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?SummaryData $props = null;

    public static function before(array &$attributes){
        $attributes['period_flag'] ??= date('Y');
    }
}