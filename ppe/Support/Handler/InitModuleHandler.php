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
    private $initController = '<?php
    
namespace Apps\Http\[module]\Controllers;

use Apps\Http\Common\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * 首页
     */
    public function index()
    {
         throw new \Exception("编写你的代码");
    }
}';
    private $providers      = '<?php
/**
 * 配置模块私有DI服务加载
 */
return [
    \Framework\Providers\ViewServiceProvider::class,
    \Apps\Providers\SessionServiceProvider::class,
];';

    /**
     * @return int|null A handler may return nothing, or a Handler::HANDLE_* constant
     */
    public function handle()
    {
        $di     = Di::getDefault();
        $module = $di->getShared('module');

        if (!is_dir($module->modulePath)) {
            mkdir($module->modulePath, 0755, true);
            mkdir($module->modulePath . '/Controllers', 0755, true);
            mkdir($module->modulePath . '/Config', 0755, true);
            mkdir($module->modulePath . '/Views', 0755, true);

            file_put_contents($module->modulePath . '/Config/providers.php', $this->providers);
            $moduleName = pathinfo($module->modulePath)['basename'];
            $string     = str_replace(['[module]'], [$moduleName], $this->initController);
            file_put_contents($module->modulePath . '/Controllers/IndexController.php', $string);
        }
    }
}