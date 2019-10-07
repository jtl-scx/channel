<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/10/07
 */

namespace JTL\SCX\Channel;

use JTL\SCX\Lib\Channel\Controller\AbstractSignUpController;

class SignUpController extends AbstractSignUpController
{
    /**
     * @param string $session
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(?string $session): void
    {
        $this->renderTemplate();
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $session
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function signUp(?string $username, ?string $password, ?string $session): void
    {
        $signUpSuccessful = false;

        if ($username === 'test' && $password === 'foo') {
            $signUpSuccessful = true;
        }

        $this->renderTemplate(['signUpSuccessful' => $signUpSuccessful]);
    }
}
