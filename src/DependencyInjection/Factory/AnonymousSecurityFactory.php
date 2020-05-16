<?php

declare(strict_types=1);

namespace Tuzex\Bundle\Security\DependencyInjection\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AnonymousFactory;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AnonymousSecurityFactory extends AnonymousFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $builder, $id, $config, $userProvider, $defaultEntryPoint)
    {
        $results = parent::create($builder, $id, $config, $userProvider, $defaultEntryPoint);

        $listener = $builder->getDefinition('security.authentication.listener.anonymous.'.$id);
        $listener->setArguments([]);

        return $results;
    }
}
