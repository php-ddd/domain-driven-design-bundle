<?php

namespace PhpDDD\DomainDrivenDesignBundle\Tests\DependencyInjection;

use PhpDDD\DomainDrivenDesignBundle\DependencyInjection\Configuration;
use PHPUnit_Framework_TestCase;

/**
 *
 */
final class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \PhpDDD\DomainDrivenDesignBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testGetConfigTreeBuilder()
    {
        $configuration = new Configuration();
        $treeBuilder   = $configuration->getConfigTreeBuilder();
        $tree          = $treeBuilder->buildTree();
        $this->assertEquals('domain_driven_design', $tree->getName());
        $this->assertEquals('domain_driven_design', $tree->getPath());
        $this->assertCount(3, $tree->getChildren());
        $this->assertEquals(
            ['command', 'command_event', 'event'],
            array_keys($treeBuilder->buildTree()->getChildren())
        );
    }
}
