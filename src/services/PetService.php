<?php

namespace winwin\petClinic\services;

use kuiper\di\annotation\Inject;
use kuiper\helper\Arrays;
use winwin\db\orm\Repository;
use winwin\petClinic\dao;
use winwin\petClinic\models\Pet;
use winwin\petClinic\models\PetType;
use winwin\petClinic\models\Visit;

class PetService implements PetServiceInterface
{
    /**
     * @Inject("PetRepository")
     *
     * @var Repository
     */
    private $petRepository;

    /**
     * @Inject("VisitRepository")
     *
     * @var Repository
     */
    private $visitRepository;

    /**
     * @Inject("PetTypeRepository")
     *
     * @var Repository
     */
    private $petTypeRepository;

    /**
     * @param int $ownerId
     *
     * @return Pet[]
     */
    public function findByOwnerId($ownerId)
    {
        /** @var dao\Pet[] $petDoList */
        $petDoList = $this->petRepository->query(['owner_id' => $ownerId]);
        $pets = [];
        if (!empty($petDoList)) {
            /** @var dao\PetType[] $petTypeDoList */
            $petTypeDoList = $this->petTypeRepository->query([
                'id' => array_unique(Arrays::pull($petDoList, 'typeId', Arrays::GETTER)),
            ]);
            $petTypes = [];
            foreach ($petTypeDoList as $petTypeDo) {
                $petTypes[$petTypeDo->getId()] = (new PetType())->setName($petTypeDo->getName());
            }
            foreach ($petDoList as $petDo) {
                $pet = $this->thawPet($petDo);
                $pet->setType($petTypes[$petDo->getTypeId()]);
                $pets[] = $pet;
            }

            /** @var dao\Visit[] $visitDoList */
            $visitDoList = $this->visitRepository->query([
                'pet_id' => Arrays::pull($petDoList, 'id', Arrays::GETTER),
            ]);
            $visits = [];
            foreach ($visitDoList as $visitDo) {
                $visits[$visitDo->getPetId()][] = (new Visit())
                    ->setVistDate($visitDo->getVisitDate())
                    ->setDescription($visitDo->getDescription());
            }
            foreach ($pets as $pet) {
                if (isset($visits[$pet->getPetId()])) {
                    $pet->setVisits($visits[$pet->getPetId()]);
                }
            }
        }

        return $pets;
    }

    /**
     * @param dao\Pet $petDo
     *
     * @return Pet
     */
    private function thawPet($petDo)
    {
        return (new Pet())
            ->setPetId($petDo->getId())
            ->setOwnerId($petDo->getOwnerId())
            ->setName($petDo->getName())
            ->setBirthDate($petDo->getBirthDate());
    }

    /**
     * @param Repository $petRepository
     */
    public function setPetRepository($petRepository)
    {
        $this->petRepository = $petRepository;
    }

    /**
     * @param Repository $visitRepository
     */
    public function setVisitRepository($visitRepository)
    {
        $this->visitRepository = $visitRepository;
    }

    /**
     * @param Repository $petTypeRepository
     */
    public function setPetTypeRepository($petTypeRepository)
    {
        $this->petTypeRepository = $petTypeRepository;
    }
}
