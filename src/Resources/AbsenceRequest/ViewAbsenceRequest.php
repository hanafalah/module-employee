<?php

namespace Hanafalah\ModuleEmployee\Resources\AbsenceRequest;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewAbsenceRequest extends ApiResource
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
      'id'            => $this->id, 
      'employee_id'   => $this->employee_id, 
      'employee'      => $this->prop_employee,
      'absence_type'  => $this->absence_type,
      'total_day'     => $this->total_day, 
      'dates'         => $this->dates, 
      'reason'        => $this->reason, 
      'status'        => $this->status, 
      'approver_type' => $this->approver_type, 
      'approver_id'   => $this->approver_id, 
      'approved_at'   => $this->approved_at
    ];
    return $arr;
  }
}
