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
class Pet
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
     * @var int
     */
    private $ownerId;

    /**
     * @Column
     *
     * @var int
     */
    private $typeId;

    /**
     * @Column
     *
     * @var string
     */
    private $name;

    /**
     * @Column
     *
     * @var \DateTime
     */
    private $birthDate;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getOwnerId()
    {
        return $this->ownerId;
    }

    public function setOwnerId($ownerId)
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getTypeId()
    {
        return $this->typeId;
    }

    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTime $birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }
}
