<?php

namespace MiguelAlcainoTest\MindbodyApiClientBundle\Tests\unit\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use MiguelAlcaino\MindbodyApiClient\MindbodyREST\BaseRequester\MindbodyRESTRequester;
use MiguelAlcaino\MindbodyApiClient\MindbodyREST\RESTEndpoint\Sale\SaleRESTRequester;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\BaseRequester\MindbodySOAPRequester;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\Serializer\Deserializer\MindbodyDeserializer;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\Serializer\Factory\JmsSerializerFactory;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\Serializer\Serializer\MindbodySerializer;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\SOAPBody\Factory\SourceCredentialsFactory;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\SOAPBody\Factory\UserCredentialsFactory;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\SOAPBody\Request\SourceCredentials;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\SOAPBody\Request\UserCredentials;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\SOAPService\ClassService\ClassServiceSOAPRequester;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\SOAPService\ClientService\ClientServiceSOAPRequester;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\SOAPService\SaleService\SaleServiceSOAPRequester;
use MiguelAlcaino\MindbodyApiClient\MindbodySOAP\SOAPService\SiteService\SiteServiceSOAPRequester;
use MiguelAlcaino\MindbodyApiClientBundle\DependencyInjection\MiguelAlcainoMindbodyApiClientExtension;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class BundleExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new MiguelAlcainoMindbodyApiClientExtension(),
        ];
    }

    public function testDefinedServices()
    {
        $this->load(
            [
                'credentials' => [
                    'source_name'         => 'fake_sn',
                    'source_password'     => 'fake_sp',
                    'sites_ids'           => [1],
                    'admin_user_name'     => 'fake_aun',
                    'admin_user_password' => 'fake_aup',
                ],
                'rest' => [
                    'api_key' => 'FAKE-API-KEY'
                ]
            ]
        );

        $this->assertContainerBuilderHasService(SourceCredentialsFactory::class);
        $this->assertContainerBuilderHasService(UserCredentialsFactory::class);
        $this->assertContainerBuilderHasService('mindbody_client_bundle.guzzle_client');
        $this->assertContainerBuilderHasService(MindbodySOAPRequester::class);
        $this->assertContainerBuilderHasService(JmsSerializerFactory::class);
        $this->assertContainerBuilderHasService(MindbodyDeserializer::class);
        $this->assertContainerBuilderHasService(UserCredentials::class);
        $this->assertContainerBuilderHasService(SourceCredentials::class);
        $this->assertContainerBuilderHasService(MindbodySerializer::class);
        $this->assertContainerBuilderHasService(ClassServiceSOAPRequester::class);
        $this->assertContainerBuilderHasService(ClientServiceSOAPRequester::class);
        $this->assertContainerBuilderHasService(SaleServiceSOAPRequester::class);
        $this->assertContainerBuilderHasService(SiteServiceSOAPRequester::class);
        $this->assertContainerBuilderHasService(MindbodyRESTRequester::class);
        $this->assertContainerBuilderHasService(SaleRESTRequester::class);
    }

    public function testIncorrectConfig()
    {
        $this->expectException(InvalidConfigurationException::class);
        $this->load(['not-a-valid-key' => 'fake-value']);
    }
}
