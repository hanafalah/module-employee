<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\ModuleEmployee\Contracts\Data\ShiftScheduleData as DataShiftScheduleData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\DateFormat;

class ShiftScheduleData extends EmployeeStuffData implements DataShiftScheduleData
{
    #[MapInputName('start_at')]
    #[MapName('start_at')]
    #[DateFormat('H:i:s')]
    public string $start_at;

    #[MapInputName('end_at')]
    #[MapName('end_at')]
    #[DateFormat('H:i:s')]
    public string $end_at;
    
    public static function before(array &$attributes){
        $attributes['flag'] = 'ShiftSchedule';
    }

    public static function after(mixed $data): ShiftScheduleData{
        $data->props['start_at'] = $data->start_at;
        $data->props['end_at'] = $data->end_at;
        return $data;
    }
}