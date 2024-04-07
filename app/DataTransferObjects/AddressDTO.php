<?php

namespace App\DataTransferObjects;
class AddressDTO
{
    public function __construct(
        public string $addressable_id,
        public string $addressable_type,
        public string $title,
        public float|null $latitude,
        public float|null $longitude,
        public string $description,
        public string|null $phone,
    )
    {

    }
}
