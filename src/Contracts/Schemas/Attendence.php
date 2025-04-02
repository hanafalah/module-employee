<?php

namespace Hanafalah\ModuleEmployee\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Hanafalah\ModuleEmployee\Contracts\Data\AttendenceData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface Attendence extends DataManagement
{
    public function getAttendence(): mixed;
    public function prepareShowAttendence(?Model $model = null, ?array $attributes = null): Model;
    public function showAttendence(?Model $model = null): array;
    public function prepareStoreAttendence(AttendenceData $attendence_dto): Model;
    public function storeAttendence(? AttendenceData $attendence_dto = null): array;
    public function prepareViewAttendencePaginate(PaginateData $paginate_dto): LengthAwarePaginator;
    public function viewAttendencePaginate(? PaginateData $paginate_dto = null): array;
    public function prepareViewAttendenceList(): Collection;
    public function viewAttendenceList(): array;
    public function prepareDeleteAttendence(? array $attributes = null): bool;
    public function deleteAttendence(): bool;
    public function attendence(mixed $conditionals = null): Builder;
    
    
}
