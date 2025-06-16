<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\CardIdentityData;
use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeData as DataEmployeeData;
use Hanafalah\ModulePeople\Contracts\Data\PeopleData;
use Hanafalah\ModuleUser\Contracts\Data\UserReferenceData;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\DateFormat;

class EmployeeData extends Data implements DataEmployeeData{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('uuid')]
    #[MapName('uuid')]
    public ?string $uuid = null;

    #[MapInputName('card_identity')]
    #[MapName('card_identity')]
    public ?CardIdentityData $card_identity = null;

    #[MapInputName('profession_id')]
    #[MapName('profession_id')]
    public mixed $profession_id = null;

    #[MapInputName('occupation_id')]
    #[MapName('occupation_id')]
    public mixed $occupation_id = null;

    #[MapInputName('hired_at')]
    #[MapName('hired_at')]
    public ?string $hired_at = null;

    #[MapInputName('people')]
    #[MapName('people')]
    public PeopleData $people;

    #[MapInputName('user_reference')]
    #[MapName('user_reference')]
    public ?UserReferenceData $user_reference;

    #[MapInputName('employee_type')]
    #[MapName('employee_type')]
    public ?EmployeeTypeData $employee_type;

    #[MapInputName('shift_id')]
    #[MapName('shift_id')]
    public mixed $shift_id = null;

    #[MapInputName('status')]
    #[MapName('status')]
    public ?string $status = null;

    #[MapInputName('profile')]
    #[MapName('profile')]
    public string|UploadedFile|null $profile = null;

    #[MapInputName('profile_dto')]
    #[MapName('profile_dto')]
    public ?ProfilePhotoData $profile_dto = null;
    
    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function after(EmployeeData $data): EmployeeData{
        $data->props['prop_profession'] = [
            'id'   => $data->profession_id ?? null,
            'name' => null
        ];

        $new = static::new();
        if (isset($data->props['prop_profession']['id']) && !isset($data->props['prop_profession']['name'])){
            $profession = $new->ProfessionModel()->findOrFail($data->props['prop_profession']['id']);
            $data->props['prop_profession']['name'] = $profession->name;
        }

        $data->props['prop_occupation'] = [
            'id'   => $data->occupation_id ?? null,
            'name' => null
        ];

        if (isset($data->props['prop_occupation']['id']) && !isset($data->props['prop_occupation']['name'])){
            $occupation = $new->OccupationModel()->findOrFail($data->props['prop_occupation']['id']);
            $data->props['prop_occupation']['name'] = $occupation->name;
        }

        $data->props['prop_shift'] = [
            'id'   => $data->shift_id ?? null,
            'name' => null
        ];

        if (isset($data->props['prop_shift']['id']) && !isset($data->props['prop_shift']['name'])){
            $shift_model = $new->ShiftModel()->findOrFail($data->shift_id);
            $data->props['prop_shift']['name'] = $shift_model->name;
        }
        return $data;
    }
}