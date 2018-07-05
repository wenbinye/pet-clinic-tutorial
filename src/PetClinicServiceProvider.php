<?php

namespace winwin\petClinic;

use kuiper\boot\Provider;
use kuiper\di;
use kuiper\web\ErrorHandlerInterface;
use winwin\db\orm\RepositoryFactory;
use winwin\db\orm\ShardingRepositoryFactory;
use winwin\db\sharding;
use winwin\providers\DbConnectionProvider;

class PetClinicServiceProvider extends Provider
{
    public function register()
    {
        $this->services->addDefinitions([
            'OwnerRepository' => di\factory([di\get(ShardingRepositoryFactory::class), 'create'], dao\Owner::class),
            'PetRepository' => di\factory([di\get(ShardingRepositoryFactory::class), 'create'], dao\Pet::class),
            'VisitRepository' => di\factory([di\get(ShardingRepositoryFactory::class), 'create'], dao\Visit::class),
            'PetTypeRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\PetType::class),
            'VetRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\Vet::class),
            'SpecialtyRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\Specialty::class),
            'VetSpecialtyRepository' => di\factory([di\get(RepositoryFactory::class), 'create'], dao\VetSpecialty::class),
            sharding\ClusterInterface::class => di\factory([$this, 'provideDbCluster']),

            ErrorHandlerInterface::class => di\object(ErrorHandler::class),

            services\VetServiceInterface::class => di\object(services\VetService::class),
            services\OwnerServiceInterface::class => di\object(services\OwnerService::class),
            services\PetServiceInterface::class => di\object(services\PetService::class),

            admin\services\AuthProviderInterface::class => di\object(admin\services\MockAuthProvider::class),
        ]);
    }

    public function provideDbCluster()
    {
        $connections = [];
        /** @var DbConnectionProvider $dbProvider */
        $dbProvider = $this->app->get(DbConnectionProvider::class);
        foreach ($this->settings['app.database_cluster'] as $config) {
            $connections[] = $dbProvider->createConnection($config);
        }

        $strategy = new sharding\Strategy();
        $strategy->setDbRule(new sharding\HashRule('owner_id', 2))
            ->setTableRule(new sharding\HashRule('owner_id', 4));

        $cluster = new sharding\Cluster($connections);
        $cluster->setAutoCreateTable(true);
        $cluster->setTableStrategy('owner', $strategy);
        $cluster->setTableStrategy('pet', $strategy);
        $cluster->setTableStrategy('visit', $strategy);

        return $cluster;
    }
}
