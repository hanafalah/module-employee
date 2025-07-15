<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Hanafalah\ModuleEmployee\Contracts\Data\AttendenceData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @see \Hanafalah\ModuleEmployee\Schemas\Attendence
 * @method mixed export(string $type)
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array updateAttendence(?AttendenceData $attendence_dto = null)
 * @method Model prepareUpdateAttendence(AttendenceData $attendence_dto)
 * @method bool deleteAttendence()
 * @method bool prepareDeleteAttendence(? array $attributes = null)
 * @method mixed getAttendence()
 * @method ?Model prepareShowAttendence(?Model $model = null, ?array $attributes = null)
 * @method array showAttendence(?Model $model = null)
 * @method Collection prepareViewAttendenceList()
 * @method array viewAttendenceList()
 * @method LengthAwarePaginator prepareViewAttendencePaginate(PaginateData $paginate_dto)
 * @method array viewAttendencePaginate(?PaginateData $paginate_dto = null)
 * @method array storeAttendence(?AttendenceData $attendence_dto = null);
 */
interface Attendence extends DataManagement{
    public function prepareStoreAttendence(AttendenceData $attendence_dto): Model;
}
