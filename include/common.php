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

ini_set('error_log', $_ENV['LOG_ERROR_CLI'] ?? __DIR__ . '/../php_error.log');

$isDevelopment = ($_ENV['IS_DEVELOPMENT'] ?? 'false') === 'true';
$rootDirectory = realpath(__DIR__ . '/..');

$containerCache = $_ENV['DI_CONTAINER_CACHE'] ?? null;
if (empty($containerCache)) {
    $containerCache = $rootDirectory . '/var/cache/containerCache.php';
}

$listenerCache = $_ENV['LISTENER_CACHE'] ?? null;
if (empty($listenerCache)) {
    $listenerCache = $rootDirectory . '/var/cache/listenerCache.php';
}


$core = new ApplicationContext($isDevelopment, $rootDirectory, $containerCache, $listenerCache);
$core->bootstrap();
$container = $core->getContainer();
