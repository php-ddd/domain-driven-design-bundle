<?php

namespace PhpDDD\DomainDrivenDesignBundle;

use PhpDDD\DomainDrivenDesignBundle\DependencyInjection\Compiler\DispatcherCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 *
 */
final class DomainDrivenDesignBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        foreach ($this->getDispatcherCompilerPassOptions() as $options) {
            $container->addCompilerPass(
                new DispatcherCompilerPass($options['service_id'], $options['tag_name'], $options['method'])
            );
        }
    }

    /**
     * @return string[][]
     */
    private function getDispatcherCompilerPassOptions()
    {
        return [
            'command' => [
                'service_id' => 'domain_driven_design.command_dispatcher',
                'tag_name'   => 'domain_driven_design.command_subscriber',
                'method'     => 'register',
            ],
            'event' => [
                'service_id' => 'domain_driven_design.event_dispatcher',
                'tag_name'   => 'domain_driven_design.event_subscriber',
                'method'     => 'subscribe',
            ],
        ];
    }
}
