<?php
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/10/04
 */

use JTL\SCX\Channel\SignUpController;
use JTL\SCX\Lib\Channel\Template\TwigTemplateRenderer;

require_once __DIR__ . '/../include/common.php';

$params = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /** @var SignUpController $controller */
    $controller = $container->get(SignUpController::class);
    $params['signUpSuccessful'] = $controller->signUp($_POST['username'], $_POST['password']);
}

/** @var TwigTemplateRenderer $renderer */
$renderer = $container->get(TwigTemplateRenderer::class);
echo $renderer->render('signup.twig', $params);
