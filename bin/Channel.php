<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/09/06
 */

use Symfony\Component\Console\Application;

require_once __DIR__ . '/../include/common.php';

$application = new Application($_ENV['CHANNEL_NAME']);
$commandLoader = $container->get('console.command_loader');

$application->setCommandLoader($commandLoader);
$application->run();

