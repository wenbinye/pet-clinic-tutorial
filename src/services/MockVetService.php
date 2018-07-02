<?php

namespace winwin\petClinic\services;

use winwin\petClinic\models\Specialty;
use winwin\petClinic\models\Vet;

class MockVetService implements VetServiceInterface
{
    public function findAll()
    {
        return [
            (new Vet())->setFirstName('James')
            ->setLastName('Carter'),
            (new Vet())->setFirstName('Helen')
            ->setLastName('Leary')
            ->setSpecialties([
                (new Specialty())->setName('radiology'),
            ]),
        ];
    }
}
