<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/17
 * Time: 17:01
 */

namespace Framework\Providers;


use Apps\Services\EventService;

class EventServiceProvider extends ServiceProvider
{
    protected $serviceName='event';

    /**
     * Register application service.
     *
     * @return mixed
     */
    public function register()
    {
        $this->di->setShared($this->serviceName, function () {
            return new EventService();
        });
    }
}