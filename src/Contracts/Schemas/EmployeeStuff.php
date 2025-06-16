<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeStuffData;
//use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeStuffUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleEmployee\Schemas\EmployeeStuff
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateEmployeeStuff(?EmployeeStuffData $employee_stuff_dto = null)
 * @method Model prepareUpdateEmployeeStuff(EmployeeStuffData $employee_stuff_dto)
 * @method bool deleteEmployeeStuff()
 * @method bool prepareDeleteEmployeeStuff(? array $attributes = null)
 * @method mixed getEmployeeStuff()
 * @method ?Model prepareShowEmployeeStuff(?Model $model = null, ?array $attributes = null)
 * @method array showEmployeeStuff(?Model $model = null)
 * @method Collection prepareViewEmployeeStuffList()
 * @method array viewEmployeeStuffList()
 * @method LengthAwarePaginator prepareViewEmployeeStuffPaginate(PaginateData $paginate_dto)
 * @method array viewEmployeeStuffPaginate(?PaginateData $paginate_dto = null)
 * @method array storeEmployeeStuff(?EmployeeStuffData $employee_stuff_dto = null);
 * @method Builder employeeStuff(mixed $conditionals = null);
 */

interface EmployeeStuff extends DataManagement
{
    public function prepareStoreEmployeeStuff(EmployeeStuffData $employee_stuff_dto): Model;
}