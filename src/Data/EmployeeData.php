<?php

namespace Hanafalah\ModuleEmployee\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class EmployeeData extends Data{


    {
        "user": {
          "username": "helper_ane1234",
          "password": null,
          "email": "anetr@mail.com",
          "password_confirmation": null
        },
        "id": 223,
        "nip": null,
        "nik": "2364873264783264",
        "first_name": "Helper",
        "last_name": "Ane Transmedic",
        "sip": null,
        "hired_at": "2025-02-04",
        "profession_id": 2,
        "pob": "Bandung",
        "dob": "1999-01-01",
        "sex": 1,
        "profile": null,
        "roles": [
          4
        ],  
        "consultation_service": {
          "id": 542,
          "tariff_components": [
            {
              "id": 1,
              "name": "Tariff Layanan",
              "price": 100000
            }
          ]
        }
      }

    public function __construct(
        #[MapInputName('uuid')]
        #[MapName('uuid')]
        public ?string $uuid = null,
    
        #[MapInputName('name')]
        #[MapName('name')]
        public string $name,
    
        #[MapInputName('status')]
        #[MapName('status')]
        public ?string $status = null,

        #[MapInputName('address')]
        #[MapName('address')]
        public ?AddressData $address = null,
        
        #[MapInputName('props')]
        #[MapName('props')]
        public ?WorkspacePropsData $props = null
    ){}
}