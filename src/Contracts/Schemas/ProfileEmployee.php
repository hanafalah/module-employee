<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleEmployee\Contracts\Data\ProfileEmployeeData;

interface ProfileEmployee extends DataManagement
{
    public function prepareStoreProfile(ProfileEmployeeData $profile_employee_dto): Model;
    public function storeProfile(? ProfileEmployeeData $profile_employee_dto = null): array;
    public function showProfile(? Model $model = null): array;
}
