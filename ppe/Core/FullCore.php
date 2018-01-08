<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/10/20
 * Time: 10:32
 */

namespace Framework\Core;


use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;


class FullCore implements ModuleDefinitionInterface
{
    /**
     * Registers an autoloader related to the module
     *
     * @param DiInterface $dependencyInjector
     */
    public function registerAutoloaders(DiInterface $dependencyInjector = null)
    {

    }

    /**
     * Registers services related to the module
     *
     * @param DiInterface $di
     * @throws \Exception
     */
    public function registerServices(DiInterface $di)
    {
        $path      = $di->getShared('module')->modulePath . "/Config/providers.php";
        if( file_exists($path) ){
            $providers = include $path;
            foreach ($providers as $name => $class) {
                $this->initializeService(new $class($di));
            }
        }
    }

    /**
     * Initialize the Service in the Dependency Injector Container.
     *
     * @return $this
     */
    protected function initializeService($serviceProvider)
    {
        $serviceProvider->register();
    }
}