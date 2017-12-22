<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/12/22
 * Time: 14:31
 */

namespace Framework\Support\Listeners;


abstract class EventListener
{
    protected $event;

    protected function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * 执行入口
     *
     * @return mixed
     */
    abstract protected function handle();
}