<?php

declare(strict_types=1);

namespace Tuzex\Bundle\Security\DependencyInjection\Compiler;

use Tuzex\Security\User\Authentication\AnonymousAuthenticationProvider;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class OverrideAnonymousProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $builder): void
    {
        $provider = $builder->getDefinition('security.authentication.provider.anonymous');
        $provider->setClass(AnonymousAuthenticationProvider::class);
    }
}
