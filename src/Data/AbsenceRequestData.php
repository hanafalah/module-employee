<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\AbsenceRequestData as DataAbsenceRequestData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Carbon\Carbon;

class AbsenceRequestData extends Data implements DataAbsenceRequestData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('employee_id')]
    #[MapName('employee_id')]
    public mixed $employee_id = null;

    #[MapInputName('employee_model')]
    #[MapName('employee_model')]
    public ?object $employee_model = null;

    #[MapInputName('absence_type')]
    #[MapName('absence_type')]
    public string $absence_type;

    #[MapInputName('total_day')]
    #[MapName('total_day')]
    public ?int $total_day = null;

    #[MapInputName('reason')]
    #[MapName('reason')]
    public ?string $reason = null;

    #[MapInputName('status')]
    #[MapName('status')]
    public ?string $status = null;

    #[MapInputName('approver_type')]
    #[MapName('approver_type')]
    public ?string $approver_type = null;

    #[MapInputName('approver_id')]
    #[MapName('approver_id')]
    public ?string $approver_id = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?AbsenceRequestPropsData $props = null;

    public static function before(array &$attributes){
        $attributes['dates'] ??= [];
        $attributes['total_day'] = count($attributes['dates']);
    }

    public static function after(self $data): self{
        $new = self::new();
        $props = &$data->props->props;

        $employee = $new->EmployeeModel()->findOrFail($data->employee_id);
        $props['prop_employee'] = $employee->toViewApi()->only(['id','name', 'profile']);

        $data->employee_model = $employee;

        return $data;
    }
}