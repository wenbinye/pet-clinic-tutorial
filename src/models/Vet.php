<?php

namespace winwin\petClinic\models;

class Vet
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var Specialty[]
     */
    private $specialties;

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

    public function getSpecialties()
    {
        return $this->specialties;
    }

    public function setSpecialties($specialties)
    {
        $this->specialties = $specialties;

        return $this;
    }
}
