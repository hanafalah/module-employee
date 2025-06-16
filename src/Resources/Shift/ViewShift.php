<?php

namespace Hanafalah\ModuleEmployee\Resources\Shift;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewShift extends ApiResource
{
    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'id'        => $this->id,
            'name'      => $this->name,
            'off_days'  => json_decode($this->off_days ?? []),
            'event'     => $this->prop_event,
            'shift_schedules' => $this->relationValidation('shiftSchedules',function(){
                return $this->shiftSchedules->transform(function($shift_schedule){
                    return $shift_schedule->toViewApi();
                });
            })
        ];
        return $arr;
    }
}
