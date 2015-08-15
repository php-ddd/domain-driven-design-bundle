<?php

namespace PhpDDD\DomainDrivenDesignBundle\Tests\DependencyInjection\Compiler;

use PhpDDD\DomainDrivenDesign\Command\CommandDispatcher;
use PhpDDD\DomainDrivenDesignBundle\DependencyInjection\Compiler\DispatcherCompilerPass;
use PhpDDD\DomainDrivenDesignBundle\Tests\DependencyInjection\Compiler\Sample\TestCommandHandler;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 *
 */
final class DispatcherCompilerPassTest extends PHPUnit_Framework_TestCase
{
    const COMMAND_DISPATCHER_SERVICE_NAME = 'domain_driven_design.command_dispatcher';
    const COMMAND_TAG                     = 'domain_driven_design.command_subscriber';
    /**
     *
     */
    public function testProcess()
    {
        $container = $this->getContainer();
        $container
            ->register('my_command_handler', new TestCommandHandler())
            ->addTag(self::COMMAND_TAG);

        $this->process($container);

        $commandDispatcher = $container->get(self::COMMAND_DISPATCHER_SERVICE_NAME);
        $this->assertCount(1, $commandDispatcher->getHandlers());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testProcessWithoutDefinition()
    {
        $container = new ContainerBuilder();
        $container
            ->register('my_command_handler', new TestCommandHandler())
            ->addTag(self::COMMAND_TAG);

        $this->process($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    private function process(ContainerBuilder $container)
    {
        $pass = new DispatcherCompilerPass(self::COMMAND_DISPATCHER_SERVICE_NAME, self::COMMAND_TAG, 'register');
        $pass->process($container);
    }

    /**
     * @return ContainerBuilder
     */
    private function getContainer()
    {
        $container         = new ContainerBuilder();
        $container->register(self::COMMAND_DISPATCHER_SERVICE_NAME, new CommandDispatcher());

        return $container;
    }
}
