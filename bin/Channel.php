<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/06
 */

use JTL\SCX\Channel\ApplicationContext;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

$core = new ApplicationContext(
    $_ENV['IS_DEVELOPMENT'] === 'true' ? true : false,
    __DIR__ . '/../' . $_ENV['ROOT_DIRECTORY'] . '/',
    __DIR__ . '/../' . $_ENV['CONTAINER_CACHE_PATH'],
    __DIR__ . '/../' . $_ENV['LISTENER_CACHE_PATH']
);

$core->bootstrap();
$container = $core->getContainer();

$application = new Application($_ENV['CHANNEL_NAME']);
$commandLoader = $container->get('console.command_loader');

$application->setCommandLoader($commandLoader);
$application->run();

