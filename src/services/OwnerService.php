<?php

namespace winwin\petClinic\services;

use kuiper\di\annotation\Inject;
use winwin\db\ConnectionInterface;
use winwin\db\orm\ShardingRepository;
use winwin\db\sharding;
use winwin\petClinic\dao;
use winwin\petClinic\models\Owner;
use winwin\petClinic\models\Pet;
use winwin\support\exception\NotFoundException;

class OwnerService implements OwnerServiceInterface
{
    /**
     * @Inject("OwnerRepository")
     *
     * @var ShardingRepository
     */
    private $ownerRepository;

    /**
     * @Inject("PetRepository")
     *
     * @var ShardingRepository
     */
    private $petRepository;

    /**
     * @Inject()
     *
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @param string $lastName
     *
     * @return Owner[]
     */
    public function findByLastName($lastName)
    {
        $ownerIds = $this->connection->from('owner_name')
            ->select(['owner_id'])
            ->where('last_name like ?', $lastName.'%')
            ->query()
            ->fetchAll();
        /** @var sharding\Cluster $cluster */
        $cluster = $this->ownerRepository->getConnection();
        $ownerTable = $this->ownerRepository->getTableMetadata()->getName();
        $strategy = $cluster->getTableStrategy($ownerTable);
        $shards = [];
        foreach ($ownerIds as $row) {
            $shards[$strategy->getDb($row).','.$strategy->getTable($row, $ownerTable)][] = $row['owner_id'];
        }
        /** @var Owner[] $owners */
        $owners = [];
        foreach ($shards as $ownerIds) {
            /** @var dao\Owner[] $ownerDoList */
            $ownerDoList = $this->ownerRepository->query(['owner_id' => $ownerIds]);
            foreach ($ownerDoList as $ownerDo) {
                $owners[$ownerDo->getOwnerId()] = $this->thawOwner($ownerDo);
            }
            if (!empty($owners)) {
                /** @var dao\Pet[] $petDoList */
                $petDoList = $this->petRepository->query(['owner_id' => array_keys($owners)]);
                foreach ($petDoList as $petDo) {
                    $pet = (new Pet())
                        ->setId($petDo->getId())
                        ->setOwnerId($petDo->getOwnerId())
                        ->setName($petDo->getName())
                        ->setBirthDate($petDo->getBirthDate());
                    $owners[$petDo->getOwnerId()]->addPet($pet);
                }
            }
        }

        return array_values($owners);
    }

    public function find($ownerId)
    {
        /** @var dao\Owner $ownerDo */
        $ownerDo = $this->ownerRepository->findOne(['owner_id' => $ownerId]);
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
            ->setOwnerId($owner->getOwnerId())
            ->setFirstName($owner->getFirstName())
            ->setLastName($owner->getLastName())
            ->setAddress($owner->getAddress())
            ->setCity($owner->getCity())
            ->setTelephone($owner->getTelephone());
        if ($ownerDo->getOwnerId()) {
            $this->ownerRepository->update($ownerDo);
        } else {
            $ownerId = $this->generateOwnerId();
            $ownerDo->setOwnerId($ownerId);
            $owner->setOwnerId($ownerId);
            $this->ownerRepository->insert($ownerDo);
        }
        $this->connection->insert('owner_name')
            ->cols(['owner_id' => $owner->getOwnerId(),
                'last_name' => $owner->getLastName(), ])
            ->onDuplicateKeyUpdate('last_name', 'values(last_name)')
            ->execute();

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
            ->setOwnerId($ownerDo->getOwnerId())
            ->setFirstName($ownerDo->getFirstName())
            ->setLastName($ownerDo->getLastName())
            ->setAddress($ownerDo->getAddress())
            ->setCity($ownerDo->getCity())
            ->setTelephone($ownerDo->getTelephone());
    }

    private function generateOwnerId()
    {
        $this->connection->exec('update owner_id set id=last_insert_id(id)+1');

        return $this->connection->lastInsertId();
    }
}
