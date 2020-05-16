<?php

declare(strict_types=1);

namespace Tuzex\Bundle\Security;

use Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Tuzex\Bundle\Security\DependencyInjection\Compiler\BindUserRepositoryCompilerPass;
use Tuzex\Bundle\Security\DependencyInjection\Compiler\OverrideAnonymousListenerCompilerPass;
use Tuzex\Bundle\Security\DependencyInjection\Compiler\OverrideAnonymousProviderCompilerPass;
use Tuzex\Bundle\Security\DependencyInjection\Factory\AnonymousSecurityFactory;

final class SecurityUserBundle extends Bundle implements BundleInterface
{
    public function build(ContainerBuilder $builder): void
    {
        parent::build($builder);

        $builder->addCompilerPass(new BindUserRepositoryCompilerPass());
        $builder->addCompilerPass(new OverrideAnonymousProviderCompilerPass());
        $builder->addCompilerPass(new OverrideAnonymousListenerCompilerPass());

        /** @var SecurityExtension $extension */
        $extension = $builder->getExtension('security');
        $extension->addSecurityListenerFactory(new AnonymousSecurityFactory());
    }
}
