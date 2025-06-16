<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleEmployee\{
    Supports\BaseModuleEmployee
};
use Hanafalah\ModuleEmployee\Contracts\Schemas\EmployeeStuff as ContractsEmployeeStuff;
use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeStuffData;

class EmployeeStuff extends BaseModuleEmployee implements ContractsEmployeeStuff
{
    protected string $__entity = 'EmployeeStuff';
    public static $employee_stuff_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'employee_stuff',
            'tags'     => ['employee_stuff', 'employee_stuff-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreEmployeeStuff(EmployeeStuffData $employee_stuff_dto): Model{
        $add = [
            'name' => $employee_stuff_dto->name,
            'flag' => $employee_stuff_dto->flag
        ];
        if (isset($employee_stuff_dto->id)){
            $guard  = ['id' => $employee_stuff_dto->id];
            $create = [$guard, $add];
        }else{
            $create = [$add];
        }
        $employee_stuff = $this->usingEntity()->updateOrCreate(...$create);
        $this->fillingProps($employee_stuff,$employee_stuff_dto->props);
        $employee_stuff->save();
        $this->forgetTagsEntity('employee_stuff');
        return static::$employee_stuff_model = $employee_stuff;
    }
}