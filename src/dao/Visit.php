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
class Visit
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
    private $petId;

    /**
     * @Column
     *
     * @var \DateTime
     */
    private $visitDate;

    /**
     * @Column
     *
     * @var string
     */
    private $description;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getPetId()
    {
        return $this->petId;
    }

    public function setPetId($petId)
    {
        $this->petId = $petId;

        return $this;
    }

    public function getVisitDate()
    {
        return $this->visitDate;
    }

    public function setVisitDate(\DateTime $visitDate)
    {
        $this->visitDate = $visitDate;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
