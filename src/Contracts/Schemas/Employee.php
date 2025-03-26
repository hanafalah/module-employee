<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleEmployee\Data\EmployeeData;

interface Employee extends DataManagement
{
    public function showUsingRelation(): array;
    public function viewUsingRelation(): array;
    public function getEmployee(): mixed;
    public function prepareShowEmployee(?Model $model = null, ?array $attributes = null): Model;
    public function showEmployee(?Model $model = null): array;
    public function prepareStoreEmployee(EmployeeData $employee_dto): Model;
    public function storeEmployee(? EmployeeData $employee_dto = null): array;
    public function employee(mixed $conditionals = null): Builder;
    
}
