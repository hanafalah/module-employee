<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class CardIdentityData extends Data{
    public function __construct(
        #[MapInputName('nip')]
        #[MapName('nip')]
        public ?string $nip = null,
        
        #[MapInputName('sip')]
        #[MapName('sip')]
        public ?string $sip = null,

        #[MapInputName('sik')]
        #[MapName('sik')]
        public ?string $sik = null,

        #[MapInputName('str')]
        #[MapName('str')]
        public ?string $str = null,

        #[MapInputName('bpjs_ketenagakerjaan')]
        #[MapName('bpjs_ketenagakerjaan')]
        public ?string $bpjs_ketenagakerjaan = null,
    ){}
}