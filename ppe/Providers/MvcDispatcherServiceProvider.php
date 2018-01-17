<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/20
 * Time: 10:49
 */

namespace Framework\Providers;

use Apps\Events\RequestEvent;
use Phalcon\Di;
use Phalcon\Events\Manager;

class MvcDispatcherServiceProvider extends ServiceProvider
{
    /**
     * The Service name.
     * @var string
     */
    protected $serviceName = 'dispatcher';

    /**
     * Register application service.
     *
     * @return void
     */
    public function register()
    {
        $this->di->setShared(
            $this->serviceName,
            function () {
                if( IS_CLI ){
                    $dispatcher = new \Phalcon\Cli\Dispatcher();
                }else{
                    $dispatcher = new \Phalcon\Mvc\Dispatcher();
                    // 创建一个事件管理
                    $eventsManager = new Manager();
                    $eventsManager->attach("dispatch:beforeExecuteRoute", function ($event, $dispatcher) {
                        \Event::fire(new RequestEvent($dispatcher));
                    });
                    $dispatcher->setEventsManager($eventsManager);
                }
                $module     = Di::getDefault()->getShared('module');
                $dispatcher->setDefaultNamespace($module['defaultNamespace']);
                $dispatcher->setActionSuffix('');
                return $dispatcher;
            }
        );
    }
}