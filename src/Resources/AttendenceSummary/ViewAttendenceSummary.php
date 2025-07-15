<?php

namespace Hanafalah\ModuleEmployee\Resources\AttendenceSummary;

use Hanafalah\LaravelSupport\Resources\ApiResource;

class ViewAttendenceSummary extends ApiResource
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
      'id'          => $this->id,
      'employee_id' => $this->employee_id,
      'period_flag' => $this->period_flag,
      'current'     => $this->current,
      'summary'     => $this->summary
    ];
    return $arr;
  }
}
