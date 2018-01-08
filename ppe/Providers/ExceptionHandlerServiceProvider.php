<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/11/29
 * Time: 18:08
 */

namespace Framework\Providers;


use Apps\Exceptions\Kernel;
use Framework\Support\Handler\LoggerHandler;
use Whoops\Run;
use Whoops\Util\Misc;

class ExceptionHandlerServiceProvider extends ServiceProvider
{
    protected $serviceName = 'exception';

    /**
     * Register application service.
     *
     * @return mixed
     */
    public function register()
    {
        $this->di->setShared($this->serviceName,function(){
            $whoops = new Run;
            if( Misc::isCommandLine() ){
                (new Kernel())->registerForCli($whoops);
            }else{
                (new Kernel())->registerForWeb($whoops);
            }
            // 日记处理
            $whoops->pushHandler(new LoggerHandler());
            return $whoops;
        });
    }
}