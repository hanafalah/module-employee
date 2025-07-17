<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\AttendenceData as DataAttendenceData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\In;

class AttendenceData extends Data implements DataAttendenceData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;
    
    #[MapInputName('employee_id')]
    #[MapName('employee_id')]
    public mixed $employee_id = null;

    #[MapInputName('employee_model')]
    #[MapName('employee_model')]
    public ?object $employee_model = null;

    #[MapInputName('shift_id')]
    #[MapName('shift_id')]
    public mixed $shift_id = null;

    #[MapInputName('type')]
    #[MapName('type')]
    #[In('CHECK IN', 'CHECK OUT', 'ABSENCE', 'APPROVAL')]
    public string $type;

    #[MapInputName('note')]
    #[MapName('note')]
    public ?string $note = null;

    #[MapInputName('status')]
    #[MapName('status')]
    public ?string $status = null;

    #[MapInputName('author_type')]
    #[MapName('author_type')]
    public ?string $author_type = null;

    #[MapInputName('author_id')]
    #[MapName('author_id')]
    public mixed $author_id = null;

    #[MapInputName('paths')]
    #[MapName('paths')]
    public ?array $paths = [];

    #[MapInputName('props')]
    #[MapName('props')]
    public ?AttendencePropsData $props = null;
    
    public static function before(array &$attributes){
        $new = self::new();
        if ($attributes['type'] == 'CHECK IN'){
            $attributes['summary'] ??= [
                'at' => now(),
                'present' => 1
            ];

            // $employee = $new->EmployeeModel()->with('occupation')->findOrFail($attributes['employee_id']);
            // $occupation = $employee->occupation;
            // $attributes['late'] = $attributes['at']->diffInMinutes($occupation->start_work_hour) > 0 ? 1 : 0;
        }
    }

    public static function after(self $data): self{
        $new = self::new();
        $props = &$data->props->props;

        $employee = $new->EmployeeModel()->findOrFail($data->employee_id);
        $props['prop_employee'] = $employee->toViewApi()->only(['id','name']);

        $data->employee_model = $employee;

        return $data;
    }
}