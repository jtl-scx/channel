<?php
/**
 * This is an example implementation to show haw a signup process may be implemented.
 * Feel free to drop this and build your own Seller Sign-Up see
 * https://github.com/jtl-scx/channel/blob/master/docs/021_seller_signup.md
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
    $controller->index($session, null, null);
}
