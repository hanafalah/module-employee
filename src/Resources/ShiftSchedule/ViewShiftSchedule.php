<?php

namespace Hanafalah\ModuleEmployee\Resources\ShiftSchedule;

use Hanafalah\ModuleEmployee\Resources\EmployeeStuff\ViewEmployeeStuff;

class ViewShiftSchedule extends ViewEmployeeStuff
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
   */
  public function toArray(\Illuminate\Http\Request $request): array
  {
    $arr = [
      'start_at' => $this->start_at,
      'end_at' => $this->end_at
    ];
    $arr = $this->mergeArray(parent::toArray($request), $arr);
    return $arr;
  }
}
