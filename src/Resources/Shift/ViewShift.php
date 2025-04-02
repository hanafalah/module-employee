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
            'start_at'  => $this->start_at,
            'end_at'    => $this->end_at,
            'event'     => $this->prop_event
        ];
        return $arr;
    }
}
