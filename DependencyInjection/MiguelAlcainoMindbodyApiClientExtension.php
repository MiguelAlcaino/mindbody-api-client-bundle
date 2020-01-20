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

        $sourceCredentialsFactory = $container->getDefinition(SourceCredentialsFactory::class);
        $sourceCredentialsFactory->replaceArgument(0, $config['credentials']['source_name']);
        $sourceCredentialsFactory->replaceArgument(1, $config['credentials']['source_password']);
        $sourceCredentialsFactory->replaceArgument(2, $config['credentials']['sites_ids']);

        $userCredentialsFactory = $container->getDefinition(UserCredentialsFactory::class);
        $userCredentialsFactory->replaceArgument(0, $config['credentials']['admin_user_name']);
        $userCredentialsFactory->replaceArgument(1, $config['credentials']['admin_user_password']);
        $userCredentialsFactory->replaceArgument(2, $config['credentials']['sites_ids']);


    }

}
