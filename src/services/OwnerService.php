<?php

namespace winwin\petClinic\services;

use kuiper\di\annotation\Inject;
use winwin\db\orm\Repository;
use winwin\petClinic\dao;
use winwin\petClinic\models\Owner;
use winwin\petClinic\models\Pet;
use winwin\support\exception\NotFoundException;

class OwnerService implements OwnerServiceInterface
{
    /**
     * @Inject("OwnerRepository")
     *
     * @var Repository
     */
    private $ownerRepository;

    /**
     * @Inject("PetRepository")
     *
     * @var Repository
     */
    private $petRepository;

    /**
     * @param string $lastName
     *
     * @return Owner[]
     */
    public function findByLastName($lastName)
    {
        /** @var dao\Owner[] $ownerDoList */
        $ownerDoList = $this->ownerRepository->query(function ($stmt) use ($lastName) {
            return $stmt->where('last_name like ?', $lastName.'%');
        });
        /** @var Owner[] $owners */
        $owners = [];
        foreach ($ownerDoList as $ownerDo) {
            $owners[$ownerDo->getId()] = $this->thawOwner($ownerDo);
        }
        if (!empty($owners)) {
            /** @var dao\Pet[] $petDoList */
            $petDoList = $this->petRepository->query(['owner_id' => array_keys($owners)]);
            foreach ($petDoList as $petDo) {
                $pet = (new Pet())
                    ->setPetId($petDo->getId())
                    ->setOwnerId($petDo->getOwnerId())
                    ->setName($petDo->getName())
                    ->setBirthDate($petDo->getBirthDate());
                $owners[$petDo->getOwnerId()]->addPet($pet);
            }
        }

        return array_values($owners);
    }

    public function find($ownerId)
    {
        $ownerDo = $this->ownerRepository->findOne($ownerId);
        if (!$ownerDo) {
            throw new NotFoundException("owner '$ownerId' does not exist");
        }

        return $this->thawOwner($ownerDo);
    }

    /**
     * @param Owner $owner
     *
     * @return Owner
     */
    public function save(Owner $owner)
    {
        $ownerDo = (new dao\Owner())
            ->setId($owner->getOwnerId())
            ->setFirstName($owner->getFirstName())
            ->setLastName($owner->getLastName())
            ->setAddress($owner->getAddress())
            ->setCity($owner->getCity())
            ->setTelephone($owner->getTelephone())
            ;
        if ($ownerDo->getId()) {
            $this->ownerRepository->update($ownerDo);
        } else {
            $this->ownerRepository->insert($ownerDo);
        }
        $owner->setOwnerId($ownerDo->getId());

        return $owner;
    }

    /**
     * @param dao\Owner $ownerDo
     *
     * @return Owner
     */
    protected function thawOwner($ownerDo)
    {
        return (new Owner())
            ->setOwnerId($ownerDo->getId())
            ->setFirstName($ownerDo->getFirstName())
            ->setLastName($ownerDo->getLastName())
            ->setAddress($ownerDo->getAddress())
            ->setCity($ownerDo->getCity())
            ->setTelephone($ownerDo->getTelephone());
    }
}
