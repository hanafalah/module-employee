<?php

namespace Hanafalah\ModuleEmployee\Data;

use Carbon\Carbon;
use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\ShiftData as DataShiftData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\DateFormat;

class ShiftData extends Data implements DataShiftData{
    public function __construct(
        #[MapInputName('id')]
        #[MapName('id')]
        public mixed $id = null,

        #[MapInputName('name')]
        #[MapName('name')]
        public string $name,

        #[MapInputName('start_at')]
        #[MapName('start_at')]
        #[DateFormat('Y-m-d H:i:s')]
        public ?string $start_at,

        #[MapInputName('end_at')]
        #[MapName('end_at')]
        #[DateFormat('Y-m-d H:i:s')]
        public ?string $end_at,

        #[MapInputName('event_type')]
        #[MapName('event_type')]
        public ?string $event_type = null,

        #[MapInputName('event_id')]
        #[MapName('event_id')]
        public mixed $event_id = null
    ){
        if (isset($this->start_at)){
            $this->start_at = Carbon::parse($this->start_at)->toDateTimeString();
        }

        if (isset($this->end_at)){
            $this->end_at = Carbon::parse($this->end_at)->toDateTimeString();
        }
    }
}