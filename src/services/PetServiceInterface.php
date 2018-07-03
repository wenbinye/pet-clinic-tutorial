<?php

namespace winwin\petClinic\services;

use winwin\petClinic\models\Pet;

interface PetServiceInterface
{
    /**
     * @param int $ownerId
     *
     * @return Pet[]
     */
    public function findByOwnerId($ownerId);
}
