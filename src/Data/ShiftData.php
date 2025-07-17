<?php

namespace Hanafalah\ModuleEmployee\Data;

use Carbon\Carbon;
use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\ShiftData as DataShiftData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\DateFormat;

class ShiftData extends Data implements DataShiftData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('off_days')]
    #[MapName('off_days')]
    public ?array $off_days = null;

    #[MapInputName('event_type')]
    #[MapName('event_type')]
    public ?string $event_type = null;

    #[MapInputName('event_id')]
    #[MapName('event_id')]
    public mixed $event_id = null;

    #[MapInputName('shift_schedule_ids')]
    #[MapName('shift_schedule_ids')]
    public ?array $shift_schedule_ids = null;

    #[MapInputName('shift_schedules')]
    #[MapName('shift_schedules')]
    #[DataCollectionOf(ShiftScheduleData::class)]
    public ?array $shift_schedules = null;

    #[MapInputName('shift_has_schedules')]
    #[MapName('shift_has_schedules')]
    #[DataCollectionOf(ShiftHasScheduleData::class)]
    public ?array $shift_has_schedules = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}