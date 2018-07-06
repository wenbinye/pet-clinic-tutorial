<?php

namespace winwin\petClinic;

use kuiper\boot\Provider;
use kuiper\di;
use kuiper\web\ErrorHandlerInterface;
use winwin\db\orm\RepositoryFactory;

class PetClinicServiceProvider extends Provider
{
    public function register()
    {
        $this->services->addDefinitions([
            'OwnerRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\Owner::class),
            'PetRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\Pet::class),
            'PetTypeRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\PetType::class),
            'VisitRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\Visit::class),
            'VetRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\Vet::class),
            'SpecialtyRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\Specialty::class),
            'VetSpecialtyRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\VetSpecialty::class),

            ErrorHandlerInterface::class => di\object(ErrorHandler::class),

            services\VetServiceInterface::class => di\object(services\RpcVetService::class),
            services\OwnerServiceInterface::class => di\object(services\OwnerService::class),
            services\PetServiceInterface::class => di\object(services\PetService::class),

            admin\services\AuthProviderInterface::class => di\object(admin\services\MockAuthProvider::class),
        ]);
    }
}
