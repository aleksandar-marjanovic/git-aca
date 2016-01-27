<?php

namespace Application\Service;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

class MyService implements EventManagerAwareInterface
{
    /*public function __construct()
    {
        echo '<b>MyService has been called</b><br>';
    }*/

    /**
     * @var EventManagerInterface
     */
    private $eventManager;
    public function foo()
    {
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('argument' => __FUNCTION__));
    }
    public function bar()
    {
        $this->getEventManager()->trigger(__FUNCTION__, $this, array('argument' => __FUNCTION__));
    }
    /**
     * Inject an EventManager instance
     *
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(
            __CLASS__,
            get_called_class()
        ));
        $this->eventManager = $eventManager;
    }
    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (!isset($this->eventManager)) {
            $this->setEventManager(new EventManager());
        }
        return $this->eventManager;
    }
}