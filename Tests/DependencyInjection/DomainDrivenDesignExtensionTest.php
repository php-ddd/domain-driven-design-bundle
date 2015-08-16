<?php

namespace PhpDDD\DomainDrivenDesignBundle\Tests\DependencyInjection;

use PhpDDD\DomainDrivenDesignBundle\DependencyInjection\DomainDrivenDesignExtension;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 *
 */
final class DomainDrivenDesignExtensionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     * @covers \PhpDDD\DomainDrivenDesignBundle\DependencyInjection\DomainDrivenDesignExtension::loadInternal
     *
     * @param bool $withCommand
     * @param bool $withEvent
     * @param bool $withCommandEvent
     */
    public function testLoadInternal($withCommand = true, $withEvent = true, $withCommandEvent = true)
    {
        $extension = new DomainDrivenDesignExtension();
        $container = new ContainerBuilder();
        $config    = [
            'array_node' => [
                'command'       => $withCommand,
                'command_event' => $withCommandEvent,
                'event'         => $withEvent,
            ],
        ];
        $extension->load($config, $container);

        $this->assertTrue($container->hasParameter('domain_driven_design.command.enabled'));
        $this->assertTrue($container->hasParameter('domain_driven_design.command_event.enabled'));
        $this->assertTrue($container->hasParameter('domain_driven_design.event.enabled'));

        $this->assertEquals($withCommand, $container->getParameter('domain_driven_design.command.enabled'));
        $this->assertEquals($withEvent, $container->getParameter('domain_driven_design.event.enabled'));
        $this->assertEquals($withCommandEvent, $container->getParameter('domain_driven_design.command_event.enabled'));
    }

    /**
     * @covers \PhpDDD\DomainDrivenDesignBundle\DependencyInjection\DomainDrivenDesignExtension::getAlias
     */
    public function testGetAlias()
    {
        $extension = new DomainDrivenDesignExtension();
        $this->assertEquals('domain_driven_design', $extension->getAlias());
    }

    public function dataProvider()
    {
        return [
            [],
            [false, false, false],
            [false, false, true],
            [false, true, false],
            [false, true, true],
            [true, true, true],
            [true, true, false],
            [true, false, true],
            [true, false, false],
        ];
    }
}
