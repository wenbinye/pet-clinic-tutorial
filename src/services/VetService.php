<?php

namespace winwin\petClinic\services;

use kuiper\di\annotation\Inject;
use kuiper\helper\Arrays;
use winwin\db\orm\Repository;
use winwin\petClinic\dao;
use winwin\petClinic\models\Specialty;
use winwin\petClinic\models\Vet;

class VetService implements VetServiceInterface
{
    /**
     * @Inject("VetRepository")
     *
     * @var Repository
     */
    private $vetRepository;

    /**
     * @Inject("VetSpecialtyRepository")
     *
     * @var Repository
     */
    private $vetSpecialtyRepository;

    /**
     * @Inject("SpecialtyRepository")
     *
     * @var Repository
     */
    private $specialtyRepository;

    /**
     * @return Vet[]
     */
    public function findAll()
    {
        /** @var dao\Vet[] $vetDoList */
        $vetDoList = $this->vetRepository->query(null);
        /** @var Vet[] $vets */
        $vets = [];
        foreach ($vetDoList as $vetDo) {
            $vets[$vetDo->getId()] = (new Vet())
                ->setFirstName($vetDo->getFirstName())
                ->setLastName($vetDo->getLastName());
        }
        if (!empty($vets)) {
            /** @var dao\VetSpecialty[] $vetSpecialtyDoList */
            $vetSpecialtyDoList = $this->vetSpecialtyRepository->query(['vet_id' => array_keys($vets)]);
            $specialtyIdList = array_unique(Arrays::pull($vetSpecialtyDoList, 'specialtyId', Arrays::GETTER));
            /** @var dao\Specialty[] $specialtyDoList */
            $specialtyDoList = $this->specialtyRepository->query(['id' => $specialtyIdList]);
            $specialties = [];
            foreach ($specialtyDoList as $specialtyDo) {
                $specialties[$specialtyDo->getId()] = (new Specialty())->setName($specialtyDo->getName());
            }
            foreach ($vetSpecialtyDoList as $vetSpecialty) {
                if (isset($specialties[$vetSpecialty->getSpecialtyId()])) {
                    $vets[$vetSpecialty->getVetId()]->addSpecialty($specialties[$vetSpecialty->getSpecialtyId()]);
                }
            }
        }

        return array_values($vets);
    }

    /**
     * @param Repository $vetRepository
     */
    public function setVetRepository($vetRepository)
    {
        $this->vetRepository = $vetRepository;
    }

    /**
     * @param Repository $vetSpecialtyRepository
     */
    public function setVetSpecialtyRepository($vetSpecialtyRepository)
    {
        $this->vetSpecialtyRepository = $vetSpecialtyRepository;
    }

    /**
     * @param Repository $specialtyRepository
     */
    public function setSpecialtyRepository($specialtyRepository)
    {
        $this->specialtyRepository = $specialtyRepository;
    }
}
