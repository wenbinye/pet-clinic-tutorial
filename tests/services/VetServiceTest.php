<?php

namespace winwin\petClinic\services;

use winwin\petClinic\DatabaseTestCaseTrait;
use winwin\petClinic\models\Vet;
use winwin\petClinic\TestCase;

class VetServiceTest extends TestCase
{
    use DatabaseTestCaseTrait;

    public function testFindAll()
    {
        $service = $this->createService();
        $vets = $service->findAll();
        $this->assertEquals(2, count($vets));
        $this->assertInstanceOf(Vet::class, $vets[0]);
        $this->assertEquals(1, count($vets[1]->getSpecialties()));
    }

    /**
     * @return VetServiceInterface
     */
    public function createService()
    {
        return $this->getContainer()->get(VetServiceInterface::class);
    }

    protected function getDataSet()
    {
        return $this->createArrayDataSet([
            'vet' => [
                [
                    'id' => '1',
                    'first_name' => 'James',
                    'last_name' => 'Carter',
                ],
                [
                    'id' => '2',
                    'first_name' => 'Helen',
                    'last_name' => 'Leary',
                ],
            ],
            'vet_specialty' => [
                [
                    'vet_id' => '2',
                    'specialty_id' => '1',
                ],
            ],
            'specialty' => [
                [
                    'id' => '1',
                    'name' => 'radiology',
                ],
            ],
        ]);
    }
}
