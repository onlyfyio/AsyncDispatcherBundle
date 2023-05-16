<?php

namespace BBIT\AsyncDispatcherBundle\Tests\Component;

use BBIT\AsyncDispatcherBundle\Component\EventDispatcher\AsynchronousEventListener;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class AsynchronousEventDispatcherListenerTest extends WebTestCase
{
    public function setUp(): void
    {
        self::bootKernel();
    }

    public function testServiceLoaded(): void
    {
       $this->assertInstanceOf(AsynchronousEventListener::class, self::$container->get('bbit_async_dispatcher.listener.terminate'));
    }
}
