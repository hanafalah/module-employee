<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleEmployee\Contracts\Data\CardIdentityData;
use Hanafalah\ModuleEmployee\Contracts\Data\ProfileEmployeeData as DataProfileEmployeeData;
use Hanafalah\ModuleUser\Contracts\Data\UserData;
use Hanafalah\ModulePeople\Contracts\Data\PeopleData;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\DateFormat;

class ProfileEmployeeData extends Data implements DataProfileEmployeeData{
    public function __construct(
        #[MapInputName('id')]
        #[MapName('id')]
        public mixed $id = null,

        #[MapInputName('people')]
        #[MapName('people')]
        public PeopleData $people,

        #[MapInputName('profile')]
        #[MapName('profile')]
        public string|UploadedFile|null $profile = null,
        
        #[MapInputName('props')]
        #[MapName('props')]
        public ?array $props = null
    ){}
}