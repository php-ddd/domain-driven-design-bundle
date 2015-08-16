<?php

namespace PhpDDD\DomainDrivenDesignBundle\Tests;

use PhpDDD\DomainDrivenDesignBundle\PhpDDDDomainDrivenDesignBundle;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 *
 */
final class PhpDDDDomainDrivenDesignBundleTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \PhpDDD\DomainDrivenDesignBundle\PhpDDDDomainDrivenDesignBundle::build
     */
    public function testBuild()
    {
        $container = $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['addCompilerPass'])
            ->getMock();
        $container->expects($this->exactly(2))
            ->method('addCompilerPass')
            ->willReturnSelf();

        $bundle = new PhpDDDDomainDrivenDesignBundle();
        $bundle->build($container);
    }
}
