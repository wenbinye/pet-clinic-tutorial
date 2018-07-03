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
            'VetRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\Vet::class),
            'SpecialtyRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\Specialty::class),
            'VetSpecialtyRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\VetSpecialty::class),
            ErrorHandlerInterface::class => di\object(ErrorHandler::class),
            services\VetServiceInterface::class => di\object(services\VetService::class),
        ]);
    }
}
