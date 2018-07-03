<?php

namespace winwin\petClinic\controllers;

use Carbon\Carbon;
use kuiper\di\annotation\Inject;
use winwin\petClinic\models\Pet;
use winwin\petClinic\models\Visit;
use winwin\petClinic\services\OwnerServiceInterface;
use winwin\petClinic\services\PetServiceInterface;
use winwin\support\validation\ValidatorFactory;

class VisitController extends Controller
{
    /**
     * @Inject
     *
     * @var OwnerServiceInterface
     */
    private $ownerService;

    /**
     * @Inject
     *
     * @var PetServiceInterface
     */
    private $petService;

    /**
     * @Inject
     *
     * @var ValidatorFactory
     */
    private $validatorFactory;

    public function initNewVisitForm($petId)
    {
        $pet = $this->petService->find($petId);
        $pet->setOwner($this->ownerService->find($pet->getOwnerId()));
        $this->render('pet/createOrUpdateVisitForm', [
            'pet' => $pet,
        ]);
    }

    public function processNewVisitForm($petId)
    {
        $pet = $this->petService->find($petId);
        $data = $this->request->getParsedBody();
        $validator = $this->validatorFactory->create($data);
        $validator->rule('required', ['visitDate', 'description'])
            ->rule('dateFormat', 'visitDate', 'Y-m-d');
        if (!$validator->validate()) {
            return $this->render('pet/createOrUpdateVisitForm', [
                'pet' => $pet->setOwner($this->ownerService->find($pet->getOwnerId())),
                'errors' => $validator->errors(),
            ]);
        }
        $visit = new Visit();
        $visit->setDescription($data['description'])
            ->setVisitDate(Carbon::parse($data['visitDate']));
        $this->petService->addVisit($petId, $visit);
        $this->redirect('/owners/'.$pet->getOwnerId());
    }
}
