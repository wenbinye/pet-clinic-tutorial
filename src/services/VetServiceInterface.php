<?php

namespace winwin\petClinic\services;

use winwin\petClinic\models\Vet;

interface VetServiceInterface
{
    /**
     * @return Vet[]
     */
    public function findAll();
}
