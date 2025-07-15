<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Hanafalah\LaravelSupport\Contracts\Data\PaginateData;
use Illuminate\Database\Eloquent\{
    Builder,
    Collection,
    Model
};
use Hanafalah\ModuleEmployee\Contracts\Schemas\Attendence as ContractsAttendence;
use Hanafalah\ModuleEmployee\Contracts\Data\AttendenceData;
use Hanafalah\ModuleEmployee\Supports\BaseModuleEmployee;

class Attendence extends BaseModuleEmployee implements ContractsAttendence
{
    protected string $__entity = 'Attendence';
    public static $attendence_model;

    public function prepareStoreAttendence(AttendenceData $attendence_dto): Model{
        switch ($attendence_dto->type) {
            case 'CHECK IN':
                $add = [
                    'shift_id' => $attendence_dto->shift_id,
                    'check_in' => now()
                ];
            break;
            case 'CHECK OUT':
                $add = ['check_out' => now()];
            break;
            case 'APPROVAL':
                $add = ['status' => $attendence_dto->status];
            break;
        }

        if (isset($attendence_dto->id)){
            $guard = ['id' => $attendence_dto->id];
        }else{
            $guard = ['employee_id' => $attendence_dto->employee_id];
        }
        $create = [$guard,$add];
        $attendence = $this->usingEntity()->updateOrCreate(...$create);
        
        $employee = $attendence_dto->employee_model;
        $employee->prop_current_attendence = $attendence->toViewApi()->resolve();
        $employee->save();

        $this->fillingProps($attendence,$attendence_dto->props);
        $attendence->save();

        return static::$attendence_model = $attendence;
    }
}

