<?php

namespace Hanafalah\ModuleEmployee\Schemas;

use Illuminate\Database\Eloquent\{
    Builder,
    Model
};
use Hanafalah\ModuleEmployee\Supports\BaseModuleEmployee;
use Hanafalah\ModuleEmployee\Contracts\Schemas\Shift as ContractsShift;
use Hanafalah\ModuleEmployee\Contracts\Data\ShiftData;
use Hanafalah\ModuleEmployee\Contracts\Data\ShiftHasScheduleData;
use Illuminate\Support\Str;

class Shift extends BaseModuleEmployee implements ContractsShift
{
    protected string $__entity = 'Shift';
    public $shift_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'shift',
            'tags'     => ['shift', 'shift-index'],
            'duration' => 24 * 60
        ]
    ];

    public function camelEntity(): string{
        return Str::camel($this->__entity).'Common';
    }

    public function prepareStoreShift(ShiftData $shift_dto): Model{
        $off_days = $shift_dto->off_days ?? [];
        $off_days = $this->mustArray($off_days);
        $shift = $this->usingEntity()->updateOrCreate([
            'id' => $shift_dto->id ?? null
        ],[
            'name'          => $shift_dto->name,            
            'off_days'      => json_encode($off_days),
            'event_type'    => $shift_dto->event_type ?? null, 
            'event_id'      => $shift_dto->event_id ?? null
        ]);

        if (isset($shift_dto->shift_has_schedules)){
            foreach ($shift_dto->shift_has_schedules as $shift_has_schedule){
                $shift_has_schedule->shift_id = $shift->getKey();
                $this->schemaContract('shift_has_schedule')->prepareStoreShiftHasSchedule($shift_has_schedule);
            }
        }

        if (isset($shift_dto->shift_schedule_ids)){
            foreach ($shift_dto->shift_schedule_ids as $shift_schedule_id){
                $shift_schedule_model = $this->schemaContract('shift_schedule')->shiftSchedule()->findOrFail($shift_schedule_id);
                $this->schemaContract('shift_has_schedule')->prepareStoreShiftHasSchedule($this->requestDTO(ShiftHasScheduleData::class,[
                    'shift_id' => $shift->getKey(),
                    'shift_schedule_id' => $shift_schedule_model->id
                ])); 
            }
        }

        if (isset($shift_dto->shift_schedules)){
            foreach ($shift_dto->shift_schedules as $shift_schedule){
                $shift_schedule_model = $this->schemaContract('shift_schedule')->prepareStoreShiftSchedule($shift_schedule);
                $this->schemaContract('shift_has_schedule')->prepareStoreShiftHasSchedule($this->requestDTO(ShiftHasScheduleData::class,[
                    'shift_id' => $shift->getKey(),
                    'shift_schedule_id' => $shift_schedule_model->id
                ])); 
            }
        }
        $this->fillingProps($shift,$shift_dto->props);
        $shift->save();
        return $this->shift_model = $shift;
    }

    public function shiftCommon(mixed $conditionals = null): Builder{
        return $this->generalSchemaModel();
    }
}

