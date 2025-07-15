<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Hanafalah\ModuleEmployee\Contracts\Data\AbsenceRequestData;
//use Hanafalah\ModuleEmployee\Contracts\Data\AbsenceRequestUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleEmployee\Schemas\AbsenceRequest
 * @method self conditionals(mixed $conditionals)
 * @method array updateAbsenceRequest(?AbsenceRequestData $absence_request_dto = null)
 * @method Model prepareUpdateAbsenceRequest(AbsenceRequestData $absence_request_dto)
 * @method bool deleteAbsenceRequest()
 * @method bool prepareDeleteAbsenceRequest(? array $attributes = null)
 * @method mixed getAbsenceRequest()
 * @method ?Model prepareShowAbsenceRequest(?Model $model = null, ?array $attributes = null)
 * @method array showAbsenceRequest(?Model $model = null)
 * @method Collection prepareViewAbsenceRequestList()
 * @method array viewAbsenceRequestList()
 * @method LengthAwarePaginator prepareViewAbsenceRequestPaginate(PaginateData $paginate_dto)
 * @method array viewAbsenceRequestPaginate(?PaginateData $paginate_dto = null)
 * @method array storeAbsenceRequest(?AbsenceRequestData $absence_request_dto = null);
 * @method Builder absenceRequest(mixed $conditionals = null);
 */

interface AbsenceRequest extends DataManagement
{
    public function prepareStoreAbsenceRequest(AbsenceRequestData $absence_request_dto): Model;
}