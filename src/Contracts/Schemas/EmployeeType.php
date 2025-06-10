<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeTypeData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface EmployeeType extends DataManagement
{
    public function getEmployeeType(): mixed;
    public function prepareShowEmployeeType(?Model $model = null, ?array $attributes = null): Model;
    public function showEmployeeType(?Model $model = null): array;
    public function prepareStoreEmployeeType(EmployeeTypeData $employee_type_dto): Model;
    public function storeEmployeeType(? EmployeeTypeData $employee_type_dto = null): array;
    public function prepareViewEmployeeTypePaginate(PaginateData $paginate_dto): LengthAwarePaginator;
    public function viewEmployeeTypePaginate(? PaginateData $paginate_dto = null): array;
    public function prepareViewEmployeeTypeList(): Collection;
    public function viewEmployeeTypeList(): array;
    public function prepareDeleteEmployeeType(? array $attributes = null): bool;
    public function deleteEmployeeType(): bool;
    public function employeeType(mixed $conditionals = null): Builder;
    
    
}
