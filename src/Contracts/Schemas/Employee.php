<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeData;
use Hanafalah\ModuleEmployee\Contracts\Data\ProfileEmployeeData;
use Hanafalah\ModuleEmployee\Contracts\Data\ProfilePhotoData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @see \Hanafalah\ModuleFunding\Schemas\Employee
 * @method self conditionals(mixed $conditionals)
 * @method bool deleteEmployee()
 * @method mixed getEmployee()
 * @method array showEmployee(?Model $model = null)
 * @method Collection prepareViewEmployeeList()
 * @method array viewEmployeeList()
 * @method LengthAwarePaginator prepareViewEmployeePaginate(PaginateData $paginate_dto)
 * @method array viewEmployeePaginate(?PaginateData $paginate_dto = null)
 * @method array storeEmployee(?EmployeeData $employee_dto = null)
 */

interface Employee extends DataManagement
{
    public function prepareShowEmployee(?Model $model = null, ?array $attributes = null): Model;
    public function prepareShowProfile(?Model $model = null, ?array $attributes = null): Model;
    public function showProfile(?Model $model = null): array;
    public function prepareStoreEmployee(EmployeeData $employee_dto): Model;
    public function prepareStoreProfile(ProfileEmployeeData $profile_employee_dto): Model;
    public function storeProfile(? ProfileEmployeeData $profile_employee_dto = null): array;
    public function prepareShowProfilePhoto(? Model $model = null, ?array $attributes = null): mixed;
    public function showProfilePhoto(? Model $model = null): mixed;
    public function prepareStoreProfilePhoto(ProfilePhotoData $profile_photo_dto): Model;
    public function storeProfilePhoto(?ProfilePhotoData $profile_photo_dto = null): array;
    public function prepareDeleteEmployee(? array $attributes = null): bool;
    public function employee(mixed $conditionals = null): Builder;
}
