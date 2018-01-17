<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/12/22
 * Time: 15:49
 */

namespace Framework\Support\Events;


use Phalcon\Events\ManagerInterface;

class Manager implements ManagerInterface
{
    protected $listeners;

    /**
     * Attach a listener to the events manager
     *
     * @param string $eventType
     * @param object|callable $handler
     */
    public function attach($eventType, $handler)
    {
        $this->listeners[$eventType][get_class($handler)] = $handler;
    }

    /**
     * Detach the listener from the events manager
     *
     * @param string $eventType
     * @param object $handler
     */
    public function detach($eventType, $handler)
    {
        unset($this->listeners[$eventType][get_class($handler)]);
    }

    /**
     * Removes all events from the EventsManager
     *
     * @param string $type
     */
    public function detachAll($type = null)
    {
        unset($this->listeners[$type]);
    }

    /**
     * Fires an event in the events manager causing the active listeners to be notified about it
     *
     * @param string $eventType
     * @param object $source
     * @param mixed $data
     * @return mixed
     */
    public function fire($eventType, $source=null, $data = null)
    {
        dump($eventType);
        if( is_object($eventType) ){

        }else{

        }
    }

    /**
     * Returns all the attached listeners of a certain type
     *
     * @param string $type
     * @return array
     */
    public function getListeners($type)
    {
        return $this->listeners[$type]??[];
    }
}