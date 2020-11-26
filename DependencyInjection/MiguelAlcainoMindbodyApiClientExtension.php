<?php

namespace MiguelAlcaino\MindbodyApiClientBundle\DependencyInjection;

use MiguelAlcaino\MindbodyApiClient\MindbodyREST\BaseRequester\MindbodyRESTRequester;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\SOAPBody\Factory\SourceCredentialsFactory;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\SOAPBody\Factory\UserCredentialsFactory;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class MiguelAlcainoMindbodyApiClientExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.yaml');

        $container
            ->register(SourceCredentialsFactory::class, SourceCredentialsFactory::class)
            ->setArguments(
                [
                    $config['credentials']['source_name'],
                    $config['credentials']['source_password'],
                    $config['credentials']['sites_ids'],
                ]
            );

        $container->register(UserCredentialsFactory::class, UserCredentialsFactory::class)
            ->setArguments(
                [
                    $config['credentials']['admin_user_name'],
                    $config['credentials']['admin_user_password'],
                    $config['credentials']['sites_ids'],
                ]
            );

        $container->register(MindbodyRESTRequester::class, MindbodyRESTRequester::class)
            ->setArguments(
                [
                    $config['rest']['api_key'],
                    $config['credentials']['sites_ids'][0],
                    new Reference('mindbody_client_bundle.guzzle_client')
                ]
            );
    }

}
