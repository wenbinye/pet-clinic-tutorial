<?php

namespace winwin\petClinic\services;

use kuiper\di\annotation\Inject;
use winwin\db\ConnectionInterface;
use winwin\petClinic\models\Specialty;
use winwin\petClinic\models\Vet;

class DbVetService implements VetServiceInterface
{
    /**
     * @Inject
     *
     * @var ConnectionInterface
     */
    private $connection;

    public function findAll()
    {
        $rows = $this->connection->from('vet')
            ->select(['id', 'first_name', 'last_name'])
            ->query()
            ->fetchAll(\PDO::FETCH_ASSOC);
        $vets = [];
        foreach ($rows as $row) {
            $vets[$row['id']] = (new Vet())
                ->setFirstName($row['first_name'])
                ->setLastName($row['last_name']);
        }
        if (!empty($rows)) {
            $specialtyRows = $this->connection->from('specialty as s')
                ->join('left', 'vet_specialty as v', 's.id=v.specialty_id')
                ->select(['vet_id', 'name'])
                ->where(['vet_id' => array_keys($vets)])
                ->query()
                ->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($specialtyRows as $row) {
                $vets[$row['vet_id']]->addSpecialty((new Specialty())->setName($row['name']));
            }
        }

        return array_values($vets);
    }

    /**
     * @param ConnectionInterface $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}
