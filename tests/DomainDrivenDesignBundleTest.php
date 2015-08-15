<?php

namespace PhpDDD\DomainDrivenDesignBundle\Tests;

use PhpDDD\DomainDrivenDesignBundle\DomainDrivenDesignBundle;
use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 *
 */
final class DomainDrivenDesignBundleTest extends PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $container = $this->getMockBuilder(ContainerBuilder::class)
            ->setMethods(['addCompilerPass'])
            ->getMock();
        $container->expects($this->exactly(2))
            ->method('addCompilerPass')
            ->willReturnSelf();

        $bundle = new DomainDrivenDesignBundle();
        $bundle->build($container);
    }
}
