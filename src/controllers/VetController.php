<?php

namespace winwin\petClinic\controllers;

use kuiper\di\annotation\Inject;
use winwin\petClinic\services\VetServiceInterface;

class VetController extends Controller
{
    /**
     * @Inject
     *
     * @var VetServiceInterface
     */
    private $vetService;

    public function showVetList()
    {
        $this->render('vet/vetList', ['vets' => $this->vetService->findAll()]);
    }
}
