<?php

namespace winwin\petClinic\controllers;

use Carbon\Carbon;
use kuiper\di\annotation\Inject;
use kuiper\helper\Arrays;
use winwin\petClinic\models\Pet;
use winwin\petClinic\models\PetType;
use winwin\petClinic\services\OwnerServiceInterface;
use winwin\petClinic\services\PetServiceInterface;
use winwin\support\exception\ValidationException;
use winwin\support\validation\ValidatorFactory;

class PetController extends Controller
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

    protected function getDefaultVars($page)
    {
        return [
            'types' => $this->petService->findAllTypes(),
        ];
    }

    public function initCreationForm($ownerId)
    {
        $owner = $this->ownerService->find($ownerId);
        $pet = (new Pet())->setOwner($owner);

        $this->render('pet/createOrUpdatePetForm', [
            'pet' => $pet,
        ]);
    }

    public function processCreationForm($ownerId)
    {
        $owner = $this->ownerService->find($ownerId);
        try {
            $pet = $this->bindPet();
            $pet->setOwnerId($owner->getOwnerId());
            $pet = $this->petService->save($pet);
            $this->redirect('/owners/'.$pet->getOwnerId());
        } catch (ValidationException $e) {
            $this->render('pet/createOrUpdatePetForm', [
                'pet' => array_merge(['owner' => $owner], $this->request->getParsedBody()),
                'errors' => $e->getErrors(),
            ]);
        }
    }

    public function initUpdateForm($petId)
    {
        $pet = $this->petService->find($petId);
        $pet->setOwner($this->ownerService->find($pet->getOwnerId()));
        $this->render('pet/createOrUpdatePetForm', [
            'pet' => $pet,
        ]);
    }

    public function processUpdateForm($petId)
    {
        $pet = $this->petService->find($petId);
        try {
            $modifiedPet = $this->bindPet();
            $modifiedPet->setPetId($petId);
            $this->petService->save($modifiedPet);
            $this->redirect('/owners/'.$pet->getOwnerId());
        } catch (ValidationException $e) {
            $pet->setOwner($this->ownerService->find($pet->getOwnerId()));
            $this->render('pet/createOrUpdatePetForm', [
                'pet' => Arrays::assign($pet, $this->request->getParsedBody()),
                'errors' => $e->getErrors(),
            ]);
        }
    }

    private function bindPet()
    {
        $data = $this->request->getParsedBody();
        $validator = $this->validatorFactory->create($data);
        $validator->rule('required', ['name', 'birthDate', 'type'])
            ->rule('dateFormat', 'birthDate', 'Y-m-d')
            ->rule('in', 'type', Arrays::pull($this->petService->findAllTypes(), 'name', Arrays::GETTER));
        if (!$validator->validate()) {
            throw new ValidationException($validator->errors());
        }
        $pet = new Pet();
        $pet->setName($data['name'])
            ->setType((new PetType())->setName($data['type']))
            ->setBirthDate(Carbon::parse($data['birthDate']));

        return $pet;
    }
}
