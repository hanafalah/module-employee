<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleEmployee\{
    Supports\BaseModuleEmployee
};
use Hanafalah\ModuleEmployee\Contracts\Schemas\AbsenceRequest as ContractsAbsenceRequest;
use Hanafalah\ModuleEmployee\Contracts\Data\AbsenceRequestData;

class AbsenceRequest extends BaseModuleEmployee implements ContractsAbsenceRequest
{
    protected string $__entity = 'AbsenceRequest';
    public static $absence_request_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'absence_request',
            'tags'     => ['absence_request', 'absence_request-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreAbsenceRequest(AbsenceRequestData $absence_request_dto): Model{
        $add = [
            'name' => $absence_request_dto->name
        ];
        $guard  = ['id' => $absence_request_dto->id];
        $create = [$guard, $add];
        // if (isset($absence_request_dto->id)){
        //     $guard  = ['id' => $absence_request_dto->id];
        //     $create = [$guard, $add];
        // }else{
        //     $create = [$add];
        // }

        $absence_request = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($absence_request,$absence_request_dto->props);
        $absence_request->save();
        return static::$absence_request_model = $absence_request;
    }
}