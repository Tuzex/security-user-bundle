<?php

declare(strict_types=1);

namespace Tuzex\Bundle\Security\Firewall;

use Psr\Log\LoggerInterface as Logger;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface as AuthenticationManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface as TokenStorage;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Tuzex\Security\User\Authentication\TokenFactory;

final class AnonymousAuthenticationListener
{
    private TokenStorage $tokenStorage;
    private TokenFactory $tokenFactory;
    private AuthenticationManager $authenticationManager;
    private Logger $logger;

    public function __construct(TokenStorage $tokenStorage, TokenFactory $tokenFactory, Logger $logger, AuthenticationManager $authenticationManager)
    {
        $this->tokenStorage = $tokenStorage;
        $this->tokenFactory = $tokenFactory;
        $this->authenticationManager = $authenticationManager;
        $this->logger = $logger;
    }

    public function __invoke(RequestEvent $event): void
    {
        $token = $this->tokenStorage->getToken();
        if (null !== $token) {
            return;
        }

        $token = $this->tokenFactory->create();

        try {
            $this->authenticationManager->authenticate($token);
            $this->logger->info('Populated the TokenStorage with am anonymous user token.');
        } catch (AuthenticationException $exception) {
            $this->logger->info('The authentication of an anonymous user failed.', ['exception' => $exception]);
        }

        $this->tokenStorage->setToken($token);
    }
}
