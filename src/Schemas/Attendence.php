<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Hanafalah\LaravelSupport\Concerns\Support\HasFileUpload;
use Illuminate\Database\Eloquent\{
    Model
};
use Hanafalah\ModuleEmployee\Contracts\Schemas\Attendence as ContractsAttendence;
use Hanafalah\ModuleEmployee\Contracts\Data\AttendenceData;
use Hanafalah\ModuleEmployee\Supports\BaseModuleEmployee;

class Attendence extends BaseModuleEmployee implements ContractsAttendence
{
    use HasFileUpload;
    
    protected string $__entity = 'Attendence';
    public static $attendence_model;

    protected function pushFiles(array $paths): array{
        return $this->setupFiles($paths);
    }

    public function getCurrentFiles(): array{
        return static::$attendence_model->paths ?? [];
    }

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
        $create = isset($add) ? [$guard,$add] : [$guard];
        $attendence = $this->usingEntity()->updateOrCreate(...$create);

        $employee = $attendence_dto->employee_model;
        $employee->prop_current_attendence = $attendence->toViewApi()->resolve();
        $employee->save();

        $this->fillingProps($attendence,$attendence_dto->props);

        if (isset($attendence_dto->paths) && count($attendence_dto->paths) > 0) {
            static::$attendence_model = $attendence;
            $attendence->paths = $this->pushFiles($attendence_dto->paths);
        }

        $attendence->save();
        return static::$attendence_model = $attendence;
    }
}

