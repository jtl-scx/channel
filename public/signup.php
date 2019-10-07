<?php
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/10/04
 */

use JTL\SCX\Channel\SignUpController;

require_once __DIR__ . '/../include/common.php';

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$session = $_GET['session'] ?? null;

/** @var SignUpController $controller */
$controller = $container->get(SignUpController::class);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->signUp($username, $password, $session);
} else {
    $controller->index($session);
}
