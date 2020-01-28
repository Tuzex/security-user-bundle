<?php

declare(strict_types=1);

namespace Tuzex\Bundle\Security\DependencyInjection\Compiler;

use Tuzex\Bundle\Security\Firewall\AnonymousAuthenticationListener;
use Tuzex\Security\User\Authentication\AnonymousAuthenticationProvider;
use Tuzex\Security\User\Authentication\AnonymousTokenFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class OverrideAnonymousListenerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $builder): void
    {
        $listener = $builder->getDefinition('security.authentication.listener.anonymous');
        $listener->setClass(AnonymousAuthenticationListener::class);
        $listener->setArgument(1, new Reference(AnonymousTokenFactory::class));
        $listener->setArgument(3, new Reference(AnonymousAuthenticationProvider::class));
    }
}
