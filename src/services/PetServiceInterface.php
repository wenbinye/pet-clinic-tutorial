<?php

namespace winwin\petClinic\services;

use winwin\petClinic\models\Pet;
use winwin\petClinic\models\PetType;
use winwin\petClinic\models\Visit;
use winwin\support\exception\NotFoundException;

interface PetServiceInterface
{
    /**
     * @param int $ownerId
     *
     * @return Pet[]
     */
    public function findByOwnerId($ownerId);

    /**
     * @return PetType[]
     */
    public function findAllTypes();

    /**
     * @param Pet $pet
     *
     * @return Pet
     *
     * @throws NotFoundException
     */
    public function save($pet);

    /**
     * @param int $petId
     *
     * @return Pet
     *
     * @throws NotFoundException
     */
    public function find($petId);

    /**
     * @param int   $petId
     * @param Visit $visit
     */
    public function addVisit($petId, $visit);
}
