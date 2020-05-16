<?php

declare(strict_types=1);

namespace Tuzex\Bundle\Security\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tuzex\Security\User\Authentication\Storage\AuthenticableRepository;

final class BindUserRepositoryCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $builder): void
    {
        $repositoryIds = $builder->findTaggedServiceIds('tuzex.security.user_repository');
        if (0 === count($repositoryIds)) {
            return;
        }

        $repositoryId = (string) array_key_first($repositoryIds);
        $repository = $builder->getDefinition($repositoryId);

        $repositoryClass = (string) $repository->getClass();
        $builder->setAlias(AuthenticableRepository::class, new Alias($repositoryClass));
    }
}
