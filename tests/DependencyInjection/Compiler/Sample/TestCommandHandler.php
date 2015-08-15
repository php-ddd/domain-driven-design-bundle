<?php

namespace PhpDDD\DomainDrivenDesignBundle\Tests\DependencyInjection\Compiler\Sample;

use PhpDDD\DomainDrivenDesign\Command\CommandHandlerInterface;

/**
 *
 */
final class TestCommandHandler implements CommandHandlerInterface
{
    /**
     * Returns an array of command class name this handler wants to handle.
     *
     * The array keys are the command class names (a parent class name or an interface if you wish).
     * The value can be the method name or any callable to call when the command is dispatched.
     *
     * For instance:
     *
     *  [
     *      MyCommand::class => 'myMethod',
     *      MyCommandInterface::class => [self::class, 'myStaticMethod'],
     *  ]
     *
     * @return callable[]|string[]
     */
    public static function getHandlingMethods()
    {
        return [
            TestCommand::class => 'testCommand',
        ];
    }

    public function testCommand(TestCommand $command)
    {
        return $command;
    }
}
