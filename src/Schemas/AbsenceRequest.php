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
    public $absence_request_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'absence_request',
            'tags'     => ['absence_request', 'absence_request-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreAbsenceRequest(AbsenceRequestData $absence_request_dto): Model{
        $add = [
            'absence_type'  => $absence_request_dto->absence_type,
            'total_day'     => $absence_request_dto->total_day, 
            'reason'        => $absence_request_dto->reason
        ];
        if (isset($absence_request_dto->id)){
            $guard = ['id' => $absence_request_dto->id];
        }else{
            $guard = ['employee_id' => $absence_request_dto->employee_id];
        }
        $create = [$guard,$add];
        $absence_request = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($absence_request,$absence_request_dto->props);

        if (isset($absence_request_dto->paths) && count($absence_request_dto->paths) > 0) {
            $this->absence_request_model = $absence_request;
            $absence_request->paths = $this->pushFiles($absence_request_dto->paths);
        }

        $absence_request->save();
        return $this->absence_request_model = $absence_request;
    }
}