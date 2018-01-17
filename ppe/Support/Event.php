<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/17
 * Time: 17:02
 */

namespace Framework\Support;


class Event
{
    protected $listen;

    /**
     * 动态注册
     *
     * @param $class
     * @param $listener
     */
    public function listen($class,$listener)
    {
        $this->listen[$class][] = $listener;
    }

    /**
     * 发生事件
     *
     * @param $event
     */
    public function fire($event)
    {
        $class = get_class($event);
        if( isset($this->listen[$class]) ){
            foreach ($this->listen[$class] as $listener){
                $status = (new $listener())->handle($event);
                if( $status===false ){
                    break;
                }
            }
        }
    }
}