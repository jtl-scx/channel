<?php
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/10/04
 */

use JTL\SCX\Channel\ApplicationContext;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->loadEnv(__DIR__ . '/../.env');

$core = new ApplicationContext(
    $_ENV['IS_DEVELOPMENT'] === 'true',
    __DIR__ . '/../' . $_ENV['ROOT_DIRECTORY'] . '/',
    __DIR__ . '/../' . $_ENV['CONTAINER_CACHE_PATH'],
    __DIR__ . '/../' . $_ENV['LISTENER_CACHE_PATH']
);

$core->bootstrap();
$container = $core->getContainer();
