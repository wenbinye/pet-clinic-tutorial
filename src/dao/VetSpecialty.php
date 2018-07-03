<?php

namespace winwin\petClinic\dao;

use winwin\db\orm\annotation\Column;
use winwin\db\orm\annotation\Entity;
use winwin\db\orm\annotation\Table;

/**
 * @Entity
 * @Table
 */
class VetSpecialty
{
    /**
     * @Column
     *
     * @var int
     */
    private $vetId;

    /**
     * @Column
     *
     * @var int
     */
    private $specialtyId;

    public function getVetId()
    {
        return $this->vetId;
    }

    public function setVetId($vetId)
    {
        $this->vetId = $vetId;

        return $this;
    }

    public function getSpecialtyId()
    {
        return $this->specialtyId;
    }

    public function setSpecialtyId($specialtyId)
    {
        $this->specialtyId = $specialtyId;

        return $this;
    }
}
