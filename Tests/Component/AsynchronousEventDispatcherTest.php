<?php

namespace BBIT\AsyncDispatcherBundle\Tests\Component;

use BBIT\AsyncDispatcherBundle\Component\EventDispatcher\AsynchronousEventDispatcher;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AsynchronousEventDispatcherTest extends WebTestCase
{

    public function setUp(): void
    {
        self::bootKernel();
    }

    public function testServiceLoaded(): void
    {
       $this->assertInstanceOf(AsynchronousEventDispatcher::class, self::$container->get('bbit_async_dispatcher.dispatcher'));
    }

    public function testListenerIsCalled(): void
    {
        /** @var AsynchronousEventDispatcher $dispatcher */
        $dispatcher = self::$container->get('bbit_async_dispatcher.dispatcher');

        $mockupEvent = new MockupEvent();

        $dispatcher->addAsyncEvent($mockupEvent, "test_event");
        $dispatcher->addListener("test_event", function($event, $name) use ($mockupEvent)
        {
            $this->assertInstanceOf(MockupEvent::class, $event);
            $this->assertEquals($mockupEvent, $event);

            $this->assertEquals("test_event", $name);

            MockupListener::$called = true;
        });

        // this will trigger the 'kernel.terminate' event, also triggering your dispatchAsync()
        self::$kernel->terminate(new Request(), new Response());

        $this->assertTrue(MockupListener::$called);
    }
}

class MockupListener
{
    static public $called = false;
}

class MockupEvent extends Event
{
}
