<?php

namespace PhpDDD\DomainDrivenDesignBundle\DependencyInjection\Compiler;

use RuntimeException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 *
 */
final class DispatcherCompilerPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    private $tagName;
    /**
     * @var string
     */
    private $dispatcherServiceId;
    /**
     * @var string
     */
    private $methodName;

    /**
     * @param string $dispatcherServiceId
     * @param string $tagName
     * @param string $methodName
     */
    public function __construct($dispatcherServiceId, $tagName, $methodName)
    {
        $this->dispatcherServiceId = $dispatcherServiceId;
        $this->tagName             = $tagName;
        $this->methodName          = $methodName;
    }

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $serviceId = $this->dispatcherServiceId;
        if (!$container->hasDefinition($serviceId) && !$container->hasAlias($serviceId)) {
            throw new RuntimeException(sprintf('Unknown Command Dispatcher service name "%s"', $serviceId));
        }

        $dispatcherService = $container->findDefinition($serviceId);
        foreach ($container->findTaggedServiceIds($this->tagName) as $listenerId => $attributes) {
            $this->processListenerDefinition($container, $dispatcherService, $listenerId);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param Definition       $dispatcher
     * @param string           $listenerId
     */
    private function processListenerDefinition(ContainerBuilder $container, Definition $dispatcher, $listenerId)
    {
        $def  = $container->getDefinition($listenerId);
        $tags = $def->getTag($this->tagName);
        while (null !== array_shift($tags)) {
            $dispatcher->addMethodCall($this->methodName, [new Reference($listenerId)]);
        }
    }
}
