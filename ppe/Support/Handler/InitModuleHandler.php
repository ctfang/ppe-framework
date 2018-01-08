<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/8
 * Time: 11:52
 */

namespace Framework\Support\Handler;


use Framework\Support\Handler;
use Phalcon\Di;

class InitModuleHandler extends Handler
{
    /**
     * @return int|null A handler may return nothing, or a Handler::HANDLE_* constant
     */
    public function handle()
    {
        $di = Di::getDefault();
        $module = $di->getShared('module');
        if( !is_dir($module->modulePath) ){
            dd('模块没有初始化');
        }
    }
}