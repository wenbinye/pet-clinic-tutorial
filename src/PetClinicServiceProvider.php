<?php

namespace winwin\petClinic;

use kuiper\boot\Provider;
use kuiper\di;
use kuiper\web\ErrorHandlerInterface;

class PetClinicServiceProvider extends Provider
{
    public function register()
    {
        $this->services->addDefinitions([
            ErrorHandlerInterface::class => di\object(ErrorHandler::class),
            services\VetServiceInterface::class => di\object(services\DbVetService::class),
        ]);
    }
}
