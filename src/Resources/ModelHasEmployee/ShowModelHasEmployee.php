<?php

namespace Hanafalah\ModuleEmployee\Resources\ModelHasEmployee;

use Illuminate\Support\Str;

class ShowModelHasEmployee extends ViewModelHasEmployee
{

    public function toArray(\Illuminate\Http\Request $request): array
    {
        $arr = [
            'model'     => $this->relationValidation('model', function () {
                return $this->model->toShowApi()->resolve();
            }),
            'employee' => $this->relationValidation('employee', function () {
                return $this->employee->toShowApi()->resolve();
            })
        ];
        $arr = array_merge(parent::toArray($request), $arr);
        return $arr;
    }
}
