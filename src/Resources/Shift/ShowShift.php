<?php

namespace Hanafalah\ModuleEmployee\Resources\Shift;

class ShowShift extends ViewShift
{

    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'event' => $this->relationValidation('event',function(){
                return $this->event->toShowApi()->resolve();
            })
        ];
        $arr = array_merge(parent::toArray($request), $arr);
        return $arr;
    }
}
