<?php

namespace Hanafalah\ModuleEmployee\Resources\Attendence;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewAttendence extends ApiResource
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
      'id' => $this->id, 
      'employee_id' => $this->employee_id, 
      'employee' => $this->prop_employee,
      'shift_id' => $this->shift_id, 
      'check_in' => $this->check_in, 
      'check_out' => $this->check_out,
      'status' => $this->status
    ];
    return $arr;
  }
}
