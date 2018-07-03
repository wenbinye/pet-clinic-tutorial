<?php

namespace winwin\petClinic\services;

use winwin\petClinic\models\Owner;
use winwin\support\exception\NotFoundException;

class MockOwnerService implements OwnerServiceInterface
{
    /**
     * @param int $ownerId
     *
     * @return Owner
     *
     * @throws NotFoundException
     */
    public function find($ownerId)
    {
        return (new Owner())
            ->setOwnerId(1)
            ->setFirstName('George')
            ->setLastName('Franklin')
            ->setAddress('110 W. Liberty St.')
            ->setCity('Madison')
            ->setTelephone('6085551023');
    }

    /**
     * @param Owner $owner
     *
     * @return Owner
     */
    public function save(Owner $owner)
    {
        return $owner->setOwnerId(1);
    }

    /**
     * @param string $lastName
     *
     * @return Owner[]
     */
    public function findByLastName($lastName)
    {
        return [];
    }
}
