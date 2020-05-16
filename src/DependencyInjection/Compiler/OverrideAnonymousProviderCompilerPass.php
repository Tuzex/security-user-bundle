<?php

declare(strict_types=1);

namespace Tuzex\Bundle\Security\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tuzex\Security\User\Authentication\AnonymousAuthenticationProvider;

final class OverrideAnonymousProviderCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $builder): void
    {
        $provider = $builder->getDefinition('security.authentication.provider.anonymous');
        $provider->setClass(AnonymousAuthenticationProvider::class);
    }
}
