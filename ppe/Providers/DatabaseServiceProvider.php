<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/12/15
 * Time: 16:57
 */

namespace Framework\Providers;


use Apps\Events\DbBeforeQueryEvent;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Events\Manager;

class DatabaseServiceProvider extends ServiceProvider
{
    protected $serviceName = 'db';

    /**
     * Register application service.
     *
     * @return mixed
     */
    public function register()
    {
        $this->di->setShared($this->serviceName, function () {
            $eventsManager = new Manager();
            $defaultDbConfig = \Config::get('database.default')->toArray();
            $connection  = new Mysql($defaultDbConfig);
            $eventsManager->attach('db:BeforeQuery', function ($event,$connection){
                \Event::fire(new DbBeforeQueryEvent($connection));
            });
            $connection->setEventsManager($eventsManager);
            return $connection;
        });
    }
}