<?php

namespace winwin\petClinic\dao;

use winwin\db\orm\annotation\Column;
use winwin\db\orm\annotation\Entity;
use winwin\db\orm\annotation\Table;

/**
 * @Entity
 * @Table
 */
class OwnerName
{
    /**
     * @Column
     *
     * @var int
     */
    private $ownerId;

    /**
     * @Column
     *
     * @var string
     */
    private $lastName;

    public function getOwnerId()
    {
        return $this->ownerId;
    }

    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }
}
