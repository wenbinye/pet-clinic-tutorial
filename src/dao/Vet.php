<?php

namespace winwin\petClinic\dao;

use winwin\db\orm\annotation\Column;
use winwin\db\orm\annotation\Entity;
use winwin\db\orm\annotation\GeneratedValue;
use winwin\db\orm\annotation\Id;
use winwin\db\orm\annotation\Table;

/**
 * @Entity
 * @Table
 */
class Vet
{
    /**
     * @Column
     * @Id
     * @GeneratedValue
     *
     * @var int
     */
    private $id;

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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

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
}
