<?php

namespace Hanafalah\ModuleEmployee\Data;

use Carbon\Carbon;
use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\ShiftData as DataShiftData;
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

    #[MapInputName('start_at')]
    #[MapName('start_at')]
    #[DateFormat('Y-m-d H:i:s')]
    public ?string $start_at;

    #[MapInputName('end_at')]
    #[MapName('end_at')]
    #[DateFormat('Y-m-d H:i:s')]
    public ?string $end_at;

    #[MapInputName('event_type')]
    #[MapName('event_type')]
    public ?string $event_type = null;

    #[MapInputName('event_id')]
    #[MapName('event_id')]
    public mixed $event_id = null;

    public static function after(ShiftData $data): ShiftData{
        if (isset($data->start_at)){
            $data->start_at = Carbon::parse($data->start_at)->toDateTimeString();
        }
    
        if (isset($data->end_at)){
            $data->end_at = Carbon::parse($data->end_at)->toDateTimeString();
        }
        return $data;
    }
}