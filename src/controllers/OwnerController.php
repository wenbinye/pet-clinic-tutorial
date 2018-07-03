<?php

namespace winwin\petClinic\controllers;

use kuiper\di\annotation\Inject;
use kuiper\helper\Arrays;
use winwin\petClinic\models\Owner;
use winwin\petClinic\services\OwnerServiceInterface;
use winwin\petClinic\services\PetServiceInterface;
use winwin\support\exception\ValidationException;
use winwin\support\validation\ValidatorFactory;

class OwnerController extends Controller
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

    public function initCreationForm()
    {
        $this->render('owner/createOrUpdateOwnerForm', [
            'owner' => new Owner(),
        ]);
    }

    public function initUpdateForm($ownerId)
    {
        $this->render('owner/createOrUpdateOwnerForm', [
            'owner' => $this->ownerService->find($ownerId),
        ]);
    }

    public function processCreationForm()
    {
        try {
            $owner = $this->bindOwner();
            $owner = $this->ownerService->save($owner);
            $this->redirect('/owners/'.$owner->getOwnerId());
        } catch (ValidationException $e) {
            $this->render('owner/createOrUpdateOwnerForm', [
                'owner' => $this->request->getParsedBody(),
                'errors' => $e->getErrors(),
            ]);
        }
    }

    public function processUpdateForm($ownerId)
    {
        $owner = $this->ownerService->find($ownerId);
        try {
            $owner = $this->bindOwner();
            $owner->setOwnerId($ownerId);
            $owner = $this->ownerService->save($owner);
            $this->redirect('/owners/'.$owner->getOwnerId());
        } catch (ValidationException $e) {
            $this->render('owner/createOrUpdateOwnerForm', [
                'owner' => Arrays::assign($owner, $this->request->getParsedBody()),
                'errors' => $e->getErrors(),
            ]);
        }
    }

    public function showOwner($ownerId)
    {
        $owner = $this->ownerService->find($ownerId);
        $owner->setPets($this->petService->findByOwnerId($ownerId));
        $this->render('owner/ownerDetails', ['owner' => $owner]);
    }

    public function initFindForm()
    {
        $this->render('owner/findOwners');
    }

    public function processFindForm()
    {
        $query = $this->request->getQueryParams();
        $owners = $this->ownerService->findByLastName($query['lastName'] ?? '');
        if (empty($owners)) {
            $this->render('owner/findOwners', [
                'errors' => ['lastName' => ['has not been found']],
            ]);
        } elseif (count($owners) == 1) {
            $this->redirect('/owners/'.$owners[0]->getOwnerId());
        } else {
            $this->render('owner/ownersList', ['owners' => $owners]);
        }
    }

    /**
     * @return Owner
     */
    protected function bindOwner(): Owner
    {
        $data = $this->request->getParsedBody();
        $validator = $this->validatorFactory->create($data);
        $validator->rule('required', ['firstName', 'lastName']);
        if (!$validator->validate()) {
            throw new ValidationException($validator->errors());
        }
        $owner = new Owner();
        Arrays::assign($owner, $data);

        return $owner;
    }
}
