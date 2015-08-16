<?php

namespace PhpDDD\DomainDrivenDesignBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 *
 */
final class PhpDDDDomainDrivenDesignExtension extends ConfigurableExtension
{
    /**
     * Configures the passed container according to the merged configuration.
     *
     * @param array            $mergedConfig
     * @param ContainerBuilder $container
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        foreach (['command', 'command_event', 'event'] as $featureName) {
            $enabled = (bool) $mergedConfig[$featureName];
            if (true === $enabled) {
                $loader->load(sprintf('%s.yml', $featureName));
            }
            $container->setParameter(sprintf('domain_driven_design.%s.enabled', $featureName), $enabled);
        }
    }
}
