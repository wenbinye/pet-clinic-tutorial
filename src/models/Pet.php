<?php

namespace winwin\petClinic\models;

class Pet
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $ownerId;

    /**
     * @var Owner
     */
    private $owner;

    /**
     * @var PetType
     */
    private $type;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $birthDate;

    /**
     * @var Visit[]
     */
    private $visits = [];

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Pet
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getPetId()
    {
        return $this->id ? $this->ownerId.'-'.$this->id : null;
    }

    public function setPetId($petId)
    {
        if (preg_match('/^(\d+)-(\d+)$/', $petId, $matches)) {
            $this->ownerId = $matches[1];
            $this->id = $matches[2];
        } else {
            throw new \InvalidArgumentException("petId is not valid, expected '{ownerId}-{id}', got '$petId'");
        }

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

    public function getOwner()
    {
        return $this->owner;
    }

    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

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

    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return Visit[]
     */
    public function getVisits()
    {
        return $this->visits;
    }

    /**
     * @param Visit[] $visits
     *
     * @return Pet
     */
    public function setVisits($visits)
    {
        $this->visits = $visits;

        return $this;
    }

    public function addVisit(Visit $visit)
    {
        $this->visits[] = $visit;

        return $this;
    }
}
