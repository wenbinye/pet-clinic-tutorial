<?php

namespace winwin\petClinic\services;

use kuiper\di\annotation\Inject;
use kuiper\helper\Arrays;
use winwin\db\orm\Repository;
use winwin\db\orm\ShardingRepository;
use winwin\petClinic\dao;
use winwin\petClinic\models\Pet;
use winwin\petClinic\models\PetType;
use winwin\petClinic\models\Visit;
use winwin\support\exception\NotFoundException;

class PetService implements PetServiceInterface
{
    /**
     * @Inject("PetRepository")
     *
     * @var ShardingRepository
     */
    private $petRepository;

    /**
     * @Inject("VisitRepository")
     *
     * @var ShardingRepository
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
        if (empty($petDoList)) {
            return [];
        } else {
            return $this->getPetTypeAndVisits($petDoList);
        }
    }

    public function findAllTypes()
    {
        $types = [];
        foreach ($this->petTypeRepository->query(null) as $petTypeDo) {
            /* @var dao\PetType $petTypeDo */
            $types[] = (new PetType())->setName($petTypeDo->getName());
        }

        return $types;
    }

    /**
     * @param Pet $pet
     *
     * @return Pet
     */
    public function save($pet)
    {
        $petDo = new dao\Pet();
        $petDo->setId($pet->getId())
            ->setOwnerId($pet->getOwnerId())
            ->setName($pet->getName())
            ->setBirthDate($pet->getBirthDate());
        if ($pet->getType()) {
            /** @var dao\PetType $petType */
            $petType = $this->petTypeRepository->findOne(['name' => $pet->getType()->getName()]);
            if (!$petType) {
                throw new NotFoundException("pet type '{$pet->getType()->getName()}' does not exist");
            }
            $petDo->setTypeId($petType->getId());
        }
        if ($petDo->getId()) {
            $this->petRepository->update($petDo);
        } else {
            $this->petRepository->insert($petDo);
            $pet->setId($petDo->getId());
        }

        return $pet;
    }

    public function find($petId)
    {
        $pet = new Pet();
        $pet->setPetId($petId);
        $petDo = $this->petRepository->findOne(['id' => $pet->getId(), 'owner_id' => $pet->getOwnerId()]);
        if (!$petDo) {
            throw new NotFoundException("pet '$petId' does not exist");
        }

        return $this->getPetTypeAndVisits([$petDo])[0];
    }

    public function addVisit($petId, $visit)
    {
        $pet = new Pet();
        $pet->setPetId($petId);
        $visitDo = (new dao\Visit())
            ->setPetId($pet->getId())
            ->setOwnerId($pet->getOwnerId())
            ->setVisitDate($visit->getVisitDate())
            ->setDescription($visit->getDescription());
        $this->visitRepository->insert($visitDo);
    }

    /**
     * @param dao\Pet $petDo
     *
     * @return Pet
     */
    private function thawPet($petDo)
    {
        return (new Pet())
            ->setId($petDo->getId())
            ->setOwnerId($petDo->getOwnerId())
            ->setName($petDo->getName())
            ->setBirthDate($petDo->getBirthDate());
    }

    /**
     * @param ShardingRepository $petRepository
     */
    public function setPetRepository($petRepository)
    {
        $this->petRepository = $petRepository;
    }

    /**
     * @param ShardingRepository $visitRepository
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

    /**
     * @param dao\Pet[] $petDoList
     *
     * @return Pet[]
     */
    protected function getPetTypeAndVisits($petDoList)
    {
        /** @var Pet[] $pets */
        $pets = [];
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
            'owner_id' => $pets[0]->getOwnerId(),
        ]);
        $visits = [];
        foreach ($visitDoList as $visitDo) {
            $visits[$visitDo->getPetId()][] = (new Visit())
                ->setVisitDate($visitDo->getVisitDate())
                ->setDescription($visitDo->getDescription());
        }
        foreach ($pets as $pet) {
            if (isset($visits[$pet->getId()])) {
                $pet->setVisits($visits[$pet->getId()]);
            }
        }

        return $pets;
    }
}
