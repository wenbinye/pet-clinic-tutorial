<?php

namespace winwin\petClinic\dao;

use winwin\db\orm\annotation\Column;
use winwin\db\orm\annotation\Entity;
use winwin\db\orm\annotation\Table;

/**
 * @Entity
 * @Table
 */
class Owner
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
    private $firstName;

    /**
     * @Column
     *
     * @var string
     */
    private $lastName;

    /**
     * @Column
     *
     * @var string
     */
    private $address;

    /**
     * @Column
     *
     * @var string
     */
    private $city;

    /**
     * @Column
     *
     * @var string
     */
    private $telephone;

    public function getOwnerId()
    {
        return $this->ownerId;
    }

    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

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

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }
}
