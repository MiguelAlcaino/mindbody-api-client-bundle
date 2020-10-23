<?php

namespace MiguelAlcaino\MindbodyApiClientBundle\DependencyInjection;

use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\SOAPBody\Factory\SourceCredentialsFactory;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\SOAPBody\Factory\UserCredentialsFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MiguelAlcainoMindbodyApiClientExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.yaml');

        $sourceCredentialsFactory = new SourceCredentialsFactory(
            $config['credentials']['source_name'],
            $config['credentials']['source_password'],
            $config['credentials']['sites_ids']
        );
        $container->set(SourceCredentialsFactory::class, $sourceCredentialsFactory);

        $userCredentialsFactory = new UserCredentialsFactory(
            $config['credentials']['admin_user_name'],
            $config['credentials']['admin_user_password'],
            $config['credentials']['sites_ids']
        );
        $container->set(UserCredentialsFactory::class, $userCredentialsFactory);
    }

}
