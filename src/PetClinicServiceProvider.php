<?php

namespace winwin\petClinic;

use kuiper\boot\Provider;
use kuiper\di;

class PetClinicServiceProvider extends Provider
{
    public function register()
    {
        $this->services->addDefinitions([
            services\VetServiceInterface::class => di\object(services\MockVetService::class),
        ]);
    }
}
