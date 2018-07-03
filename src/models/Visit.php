<?php

namespace winwin\petClinic\models;

class Visit
{
    /**
     * @var \DateTime
     */
    private $visitDate;

    /**
     * @var string
     */
    private $description;

    public function getVisitDate()
    {
        return $this->visitDate;
    }

    public function setVisitDate($visitDate)
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
