<?php

namespace PhpDDD\DomainDrivenDesignBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 *
 */
final class DomainDrivenDesignExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $config    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $config);
        $loader        = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        foreach (['command', 'command_event', 'event'] as $featureName) {
            $this->handleFeature($featureName, $loader, $config, $container);
        }
    }

    /**
     * @param string           $featureName
     * @param YamlFileLoader   $loader
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function handleFeature($featureName, YamlFileLoader $loader, array $config, ContainerBuilder $container)
    {
        $enabled = (bool) $config[$featureName];
        if (true === $enabled) {
            $loader->load(sprintf('%s.yml', $featureName));
        }
        $container->setParameter(sprintf('domain_driven_design.%s.enabled', $featureName), $enabled);
    }
}
