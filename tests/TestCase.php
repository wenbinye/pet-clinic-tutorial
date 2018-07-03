<?php

namespace winwin\petClinic;

use Dotenv\Dotenv;
use kuiper\helper\DataDumper;
use Psr\Container\ContainerInterface;
use winwin\db\ConnectionInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public static function setUpBeforeClass()
    {
        if (file_exists(__DIR__.'/.env')) {
            (new Dotenv(__DIR__))->load();
        }
    }

    protected function dataSet($file)
    {
        $path = $path = __DIR__.'/fixtures/'.$file;
        if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['yaml', 'json', 'php'])) {
            return DataDumper::loadFile($path);
        } else {
            return file_get_contents($path);
        }
    }

    protected function getConnection()
    {
        static $pdo;
        if (!$pdo) {
            $pdo = $this->getContainer()->get(ConnectionInterface::class);
        }

        return $this->createDefaultDBConnection($pdo, getenv('DB_NAME'));
    }

    public function getContainer(array $definitions = [])
    {
        $app = new \kuiper\boot\Application();
        $appPath = realpath(__DIR__.'/..');
        $app->useAnnotations(true)
            ->setLoader(require($appPath.'/vendor/autoload.php'))
            ->loadConfig($appPath.'/config');
        $app->bootstrap();

        $container = $app->getContainer();
        foreach ($definitions as $name => $def) {
            $container->set($name, $def);
        }

        return $this->container = $container;
    }
}
