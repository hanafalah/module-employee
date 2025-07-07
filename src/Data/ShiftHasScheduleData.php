<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\ShiftHasScheduleData as DataShiftHasScheduleData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Attributes\Validation\RequiredWithout;

class ShiftHasScheduleData extends Data implements DataShiftHasScheduleData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('shift_id')]
    #[MapName('shift_id')]
    public mixed $shift_id = null;

    #[MapInputName('shift_schedule_id')]
    #[MapName('shift_schedule_id')]
    #[Nullable]
    #[RequiredWithout('shift_schedule')]
    public mixed $shift_schedule_id = null;

    #[MapInputName('shift_schedule')]
    #[MapName('shift_schedule')]
    #[Nullable]
    #[RequiredWithout('shift_schedule_id')]
    public ?ShiftScheduleData $shift_schedule = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    
    public static function after(self $data): self
    {
        $new = self::new();
        if (isset($data->shift_schedule_id)){
            $shift_schedule = $new->ShiftScheduleModel()->findOrFail($data->shift_schedule_id);
        }
        $data->props['prop_shift_schedule'] = [
            'id'       => $data->shift_schedule_id ?? null,
            'name'     => $data->shift_schedule?->name ?? $shift_schedule->name ?? null,
            'start_at' => $data->shift_schedule?->start_at ?? $shift_schedule->start_at ?? null,
            'end_at'   => $data->shift_schedule?->end_at ?? $shift_schedule->end_at ?? null,
        ];
        return $data;
    }
}