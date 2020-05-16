<?php

declare(strict_types=1);

namespace Tuzex\Bundle\Security\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Tuzex\Security\User\Authentication\Storage\AuthenticableRepository;

final class SecurityUserExtension extends Extension implements ExtensionInterface
{
    /**
     * @var FileLocator
     */
    private $fileLocator;

    public function __construct()
    {
        $this->fileLocator = new FileLocator(__DIR__.'/../Resources/config');
    }

    public function load(array $configs, ContainerBuilder $builder): void
    {
        $this->registerTags($builder);
        $this->registerServices($builder);
    }

    private function registerTags(ContainerBuilder $builder): void
    {
        $builder->registerForAutoconfiguration(AuthenticableRepository::class)
            ->addTag('tuzex.security.user_repository');
    }

    private function registerServices(ContainerBuilder $builder): void
    {
        $loader = new XmlFileLoader($builder, $this->fileLocator);
        $loader->load('services.xml');
    }
}
