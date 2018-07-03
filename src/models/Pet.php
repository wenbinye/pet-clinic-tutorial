<?php

namespace winwin\petClinic\models;

class Pet
{
    /**
     * @var int
     */
    private $petId;

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

    public function getPetId()
    {
        return $this->petId;
    }

    public function setPetId($petId)
    {
        $this->petId = $petId;

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
