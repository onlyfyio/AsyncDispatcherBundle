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

    public function addListener($eventName, $listener, $priority = 0)
    {
        return $this->dispatcher->addListener($eventName, $listener, $priority);
    }

    // @codeCoverageIgnoreStart
    public function dispatch($event, $eventName = null)
    {
        return $this->dispatcher->dispatch($event, $eventName);
    }

    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        return $this->dispatcher->addSubscriber($subscriber);
    }

    public function removeListener($eventName, $listener)
    {
        return $this->dispatcher->removeListener($eventName, $listener);
    }

    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->dispatcher->removeSubscriber($subscriber);
    }

    public function getListeners($eventName = null)
    {
        return $this->dispatcher->getListeners($eventName);
    }

    public function hasListeners($eventName = null)
    {
        return $this->dispatcher->hasListeners($eventName);
    }

    public function getListenerPriority($eventName, $listener)
    {
        return $this->dispatcher->getListenerPriority($eventName, $listener);
    }
}
