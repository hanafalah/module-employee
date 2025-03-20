<?php

namespace Hanafalah\ModuleEmployee\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\DataManagement;

interface Employee extends DataManagement
{
    public function prepareStoreEmployee(?array $attributes = null): Model;
    public function prepareShowEmployee(?Model $model = null, ?array $attributes = null): Model;
    public function showUsingRelation(): array;
    public function viewUsingRelation(): array;
    public function showEmployee(?Model $model = null): array;
    public function storeEmployee(): array;
    public function getEmployee(): mixed;
    public function addOrChange(?array $attributes = []): self;
    public function employee(mixed $conditionals = null): Builder;
}
