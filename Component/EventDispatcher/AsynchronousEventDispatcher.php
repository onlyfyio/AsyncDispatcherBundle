<?php

namespace BBIT\AsyncDispatcherBundle\Component\EventDispatcher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AsynchronousEventDispatcher implements EventDispatcherInterface
{
    protected $dispatcher;
    protected $asyncEvents = array();

    /**
    * Constructor.
    *
    * @param EventDispatcherInterface $dispatcher
    */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
    * Dispatch all saved events.
    *
    * @return void
    */
    public function dispatchAsync()
    {
        foreach ($this->asyncEvents as $eachEntry) {
            $this->dispatcher->dispatch($eachEntry['event'], $eachEntry['name']);
        }
    }

    /**
     * Store an asynchronous event to be dispatched later.
     *
     * @param $event
     * @param string|null $eventName
     *
     * @return void
     */
    public function addAsyncEvent($event, string $eventName = null)
    {
        $this->asyncEvents[] = array(
            'name' => $eventName,
            'event' => $event,
        );
    }

    public function addListener(string $eventName, callable $listener, int $priority = 0)
    {
        return $this->dispatcher->addListener($eventName, $listener, $priority);
    }

    // @codeCoverageIgnoreStart
    public function dispatch(object $event, ?string $eventName = null): object
    {
        return $this->dispatcher->dispatch($event, $eventName);
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        return $this->dispatcher->addSubscriber($subscriber);
    }

    public function removeListener(string $eventName, callable $listener)
    {
        return $this->dispatcher->removeListener($eventName, $listener);
    }

    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->dispatcher->removeSubscriber($subscriber);
    }

    public function getListeners(?string $eventName = null): array
    {
        return $this->dispatcher->getListeners($eventName);
    }

    public function hasListeners(?string $eventName = null): bool
    {
        return $this->dispatcher->hasListeners($eventName);
    }

    public function getListenerPriority(string $eventName, callable $listener): ?int
    {
        return $this->dispatcher->getListenerPriority($eventName, $listener);
    }
}
