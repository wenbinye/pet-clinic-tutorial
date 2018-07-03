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
class Specialty
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
    private $name;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

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
}
