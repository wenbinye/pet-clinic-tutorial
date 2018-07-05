<?php

namespace winwin\petClinic\commands;

use Carbon\Carbon;
use kuiper\di\annotation\Inject;
use kuiper\helper\Arrays;
use kuiper\helper\DataDumper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use winwin\petClinic\models\Owner;
use winwin\petClinic\models\Pet;
use winwin\petClinic\models\PetType;
use winwin\petClinic\services\OwnerServiceInterface;
use winwin\petClinic\services\PetServiceInterface;

class LoadDataCommand extends Command
{
    /**
     * @Inject()
     *
     * @var OwnerServiceInterface
     */
    private $ownerService;

    /**
     * @Inject()
     *
     * @var PetServiceInterface
     */
    private $petService;

    /**
     * @Inject("app.base_path")
     *
     * @var string
     */
    private $basePath;

    /**
     * @Inject("app.dev_mode")
     *
     * @var bool
     */
    private $devMode;

    protected function configure()
    {
        $this->setName('load:data')
            ->setDescription('加载测试数据');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->devMode) {
            $output->writeln('<error>不允许在非 dev_mode 下导入数据</error>');

            return;
        }
        $data = DataDumper::loadFile($this->basePath.'/resources/data.yaml');

        foreach ($data['owner'] as $row) {
            $owner = Arrays::assign(new Owner(), $row);
            $this->ownerService->save($owner);
        }

        $petTypes = Arrays::assoc($data['pet_type'], 'id');
        foreach ($data['pet'] as $row) {
            unset($row['id']);
            $pet = Arrays::assign(new Pet(), $row);
            $pet->setType((new PetType())->setName($petTypes[$row['type_id']]['name']));
            $pet->setBirthDate(Carbon::parse($row['birth_date']));
            $this->petService->save($pet);
        }
    }
}
