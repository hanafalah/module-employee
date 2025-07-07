<?php

namespace Hanafalah\ModuleEmployee\Resources\ShiftSchedule;

use Hanafalah\ModuleEmployee\Resources\EmployeeStuff\ShowEmployeeStuff;

class ShowShiftSchedule extends ViewShiftSchedule
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [];
    $show = $this->resolveNow(new ShowEmployeeStuff($this));
    $arr = $this->mergeArray(parent::toArray($request),$show,$arr);
    return $arr;
  }
}
