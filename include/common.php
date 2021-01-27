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

$isDevelopment = $_ENV['IS_DEVELOPMENT'] === 'true';

if (isset($_ENV['PHP_ERROR_LOG'])) {
    ini_set('log_errors', 'On');
    ini_set('error_reporting', E_ALL);
    ini_set('error_log', $_ENV['PHP_ERROR_LOG']);
}

header("X-CHANNEL: " . $_ENV["CHANNEL_NAME"]);
header("X-CHANNEL-APPSRV: " . gethostname());

$rootDirectory = realpath(__DIR__ . '/..');

$containerCache = $_ENV['DI_CONTAINER_CACHE'];
if (empty($containerCache)) {
    $containerCache = $rootDirectory . '/var/cache/containerCache.php';
}

$listenerCache = $_ENV['LISTENER_CACHE'];
if (empty($listenerCache)) {
    $listenerCache = $rootDirectory . '/var/cache/listenerCache.php';
}

$core = new ApplicationContext($isDevelopment, $rootDirectory, $containerCache, $listenerCache);
$core->bootstrap();
$container = $core->getContainer();
