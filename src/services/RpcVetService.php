<?php

namespace winwin\petClinic\services;

use kuiper\di\annotation\Inject;
use winwin\petClinic\models\Specialty;
use winwin\petClinic\models\Vet;

class RpcVetService implements VetServiceInterface
{
    /**
     * @Inject()
     *
     * @var \winwin\petClinicVet\facade\VetServiceInterface
     */
    private $vetService;

    /**
     * @return Vet[]
     */
    public function findAll()
    {
        $vets = [];
        $vetDtoList = $this->vetService->findAll();

        foreach ($vetDtoList as $vetDto) {
            $vet = (new Vet())
                ->setFirstName($vetDto->getFirstName())
                ->setLastName($vetDto->getLastName());
            if ($vetDto->getSpecialties()) {
                foreach ($vetDto->getSpecialties() as $specialtyDto) {
                    $vet->addSpecialty((new Specialty())->setName($specialtyDto->getName()));
                }
            }
            $vets[] = $vet;
        }

        return $vets;
    }
}
