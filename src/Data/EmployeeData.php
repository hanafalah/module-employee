<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\CardIdentityData;
use Hanafalah\ModuleEmployee\Contracts\Data\EmployeeData as DataEmployeeData;
use Hanafalah\ModuleUser\Contracts\Data\UserData;
use Hanafalah\ModulePeople\Contracts\Data\PeopleData;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\DateFormat;

class EmployeeData extends Data implements DataEmployeeData{
    public function __construct(
        #[MapInputName('id')]
        #[MapName('id')]
        public mixed $id = null,

        #[MapInputName('card_identity')]
        #[MapName('card_identity')]
        public ?CardIdentityData $card_identity = null,

        #[MapInputName('profession_id')]
        #[MapName('profession_id')]
        public mixed $profession_id = null,

        #[MapInputName('occupation_id')]
        #[MapName('occupation_id')]
        public mixed $occupation_id = null,

        #[MapInputName('hired_at')]
        #[MapName('hired_at')]
        #[DateFormat(['Y-m-d', 'd-m-Y', 'Y-m', 'm-Y'])]
        public ?string $hired_at = null,

        #[MapInputName('people')]
        #[MapName('people')]
        public PeopleData $people,

        #[MapInputName('user')]
        #[MapName('user')]
        public ?UserData $user,
    
        #[MapInputName('status')]
        #[MapName('status')]
        public ?string $status = null,

        #[MapInputName('profile')]
        #[MapName('profile')]
        public string|UploadedFile|null $profile = null,

        #[MapInputName('profile_dto')]
        #[MapName('profile_dto')]
        public ?ProfilePhotoData $profile_dto = null,
        
        #[MapInputName('props')]
        #[MapName('props')]
        public ?array $props = null
    ){
    }
}