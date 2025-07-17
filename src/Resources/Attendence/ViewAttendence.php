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
      'reason' => $this->reason,
      'status' => $this->status,
      'paths'       => $this->paths,
    ];
    $paths_urls = [];
    if (isset($this->paths)){
      foreach ($this->paths as $path) $paths_urls[] = $this->getFullUrl($path);
    }
    $arr['url_paths'] = $paths_urls;
    return $arr;
  }
}
