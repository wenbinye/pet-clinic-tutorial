<?php

namespace winwin\petClinic\services;

use winwin\petClinic\models\Owner;
use winwin\support\exception\NotFoundException;

interface OwnerServiceInterface
{
    /**
     * @param string $lastName
     *
     * @return Owner[]
     */
    public function findByLastName($lastName);

    /**
     * @param int $ownerId
     *
     * @return Owner
     *
     * @throws NotFoundException
     */
    public function find($ownerId);

    /**
     * @param Owner $owner
     *
     * @return Owner
     */
    public function save(Owner $owner);
}
