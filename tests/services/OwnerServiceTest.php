<?php

namespace winwin\petClinic\services;

use PHPUnit\DbUnit\DataSet\IDataSet;
use winwin\petClinic\DatabaseTestCaseTrait;
use winwin\petClinic\models\Owner;
use winwin\petClinic\TestCase;

class OwnerServiceTest extends TestCase
{
    use DatabaseTestCaseTrait;

    public function testSave()
    {
        $service = $this->createService();
        $this->getConnection()->getConnection()->exec('drop table if exists owner_01');
        $owner = (new Owner())
            ->setFirstName('john')
            ->setLastName('smith');
        $service->save($owner);
        $this->assertTableRowCount('owner_01', 1);
        $this->assertTableRowCount('owner_name', 1);
    }

    /**
     * Returns the test dataset.
     *
     * @return IDataSet
     */
    protected function getDataSet()
    {
        return $this->createArrayDataSet([
            'owner_id' => [['id' => 1]],
            'owner_name' => [],
        ]);
    }

    /**
     * @return OwnerServiceInterface
     */
    private function createService()
    {
        return $this->getContainer()->get(OwnerServiceInterface::class);
    }
}
