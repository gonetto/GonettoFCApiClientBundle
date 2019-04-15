<?php

namespace Gonetto\FCApiClientBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class GonettoFCApiClientExtension extends Extension implements PrependExtensionInterface
{

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container): void
    {
        // Get all bundles
        $bundles = $container->getParameter('kernel.bundles');

        // Config EightPointsGuzzleBundle
        if (isset($bundles['EightPointsGuzzleBundle'])) {
            $container->prependExtensionConfig(
              'eight_points_guzzle',
              [
                'logging' => true,
                'clients' => [
                  'finance_consult' => [
                    'base_url' => '%gonetto_fc_api_client.base_api_url%',
                    'options' => [
                      'headers' => [
                        'Accept' => 'application/json',
                      ],
                    ],
                  ],
                ],
              ]
            );
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param array $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        // Load bundle configs
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');
        $loader->load('services.yml');
    }
}
