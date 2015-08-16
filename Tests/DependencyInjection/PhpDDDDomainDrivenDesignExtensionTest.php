<?php

namespace PhpDDD\DomainDrivenDesignBundle\Tests\DependencyInjection;

use PhpDDD\DomainDrivenDesignBundle\DependencyInjection\PhpDDDDomainDrivenDesignExtension;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 *
 */
final class PhpDDDDomainDrivenDesignExtensionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProvider
     * @covers \PhpDDD\DomainDrivenDesignBundle\DependencyInjection\PhpDDDDomainDrivenDesignExtension::loadInternal
     *
     * @param bool $withCommand
     * @param bool $withEvent
     * @param bool $withCommandEvent
     */
    public function testLoadInternal($withCommand = true, $withEvent = true, $withCommandEvent = true)
    {
        $extension = new PhpDDDDomainDrivenDesignExtension();
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
