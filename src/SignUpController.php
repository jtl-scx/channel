<?php

declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/10/07
 */

namespace JTL\SCX\Channel;

use GuzzleHttp\Exception\GuzzleException;
use JTL\SCX\Client\Exception\RequestFailedException;
use JTL\SCX\Lib\Channel\Client\Api\Seller\Request\CreateSellerRequest;
use JTL\SCX\Lib\Channel\Client\Api\Seller\SellerApi;
use JTL\SCX\Lib\Channel\Client\Model\CreateSeller;
use JTL\SCX\Lib\Channel\Controller\AbstractSignUpController;
use JTL\SCX\Lib\Channel\Template\TwigTemplateRenderer;

class SignUpController extends AbstractSignUpController
{
    private SellerApi $sellerApi;

    public function __construct(SellerApi $sellerApi, TwigTemplateRenderer $templateRenderer)
    {
        parent::__construct($templateRenderer);
        $this->sellerApi = $sellerApi;
    }

    /**
     * @param string|null $session
     * @param string|null $expiresAt
     * @param bool|null $isUpdate
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(?string $session, ?string $expiresAt, ?bool $isUpdate = null): void
    {
        $this->renderTemplate();
    }

    /**
     * @param string|null $username
     * @param string|null $password
     * @param string|null $session
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function signUp(?string $username, ?string $password, ?string $session): void
    {
        $signUpSuccessful = false;

        if ($username && $password) {

            // validate credentials

            // persist Seller and create a unique SellerId
            $sellerId = "1";

            // link seller with SCX
            $seller = new CreateSeller(['session' => $session, 'sellerId' => $sellerId]);
            try {
                $this->sellerApi->create(new CreateSellerRequest($seller));
            } catch (GuzzleException|RequestFailedException) {
                // add error handling
            }

            $signUpSuccessful = true;
        }

        $this->renderTemplate(['signUpSuccessful' => $signUpSuccessful]);
    }
}
