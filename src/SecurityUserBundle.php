<?php

declare(strict_types=1);

namespace Tuzex\Bundle\Security;

use Tuzex\Bundle\Security\DependencyInjection\Compiler\BindUserRepositoryCompilerPass;
use Tuzex\Bundle\Security\DependencyInjection\Compiler\OverrideAnonymousListenerCompilerPass;
use Tuzex\Bundle\Security\DependencyInjection\Compiler\OverrideAnonymousProviderCompilerPass;
use Tuzex\Bundle\Security\DependencyInjection\Factory\AnonymousSecurityFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;

final class SecurityUserBundle extends Bundle implements BundleInterface
{
    public function build(ContainerBuilder $builder): void
    {
        parent::build($builder);

        $builder->addCompilerPass(new BindUserRepositoryCompilerPass());
        $builder->addCompilerPass(new OverrideAnonymousProviderCompilerPass());
        $builder->addCompilerPass(new OverrideAnonymousListenerCompilerPass());

        $extension = $builder->getExtension('security');
        $extension->addSecurityListenerFactory(new AnonymousSecurityFactory());
    }
}
