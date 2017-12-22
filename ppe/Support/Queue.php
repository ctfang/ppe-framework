<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/12/20
 * Time: 19:59
 */

namespace Framework\Support;

use Framework\Support\Exceptions\QueueException;
use Phalcon\Di;

abstract class Queue
{
    protected $queueName = 'default';
    protected $setPrefix = 'setParam';
    protected $allParams;

    /**
     * 任务入口
     *
     * @return mixed
     */
    abstract public function handle();

    /**
     * 执行前
     */
    public function setUp()
    {

    }

    /**
     * 执行后
     */
    public function tearDown()
    {

    }

    /**
     * 执行队列
     */
    public final function perform()
    {
        try{
            $this->initParameters($this->args);
            $this->saveParams($this->args);
            $this->handle();
        }catch (\Exception $exception){
            $ErrorException = new QueueException($exception->getMessage(),$exception->getCode(),$exception->getCode(),$exception->getFile(),$exception->getLine(),$exception);
            Di::getDefault()->getShared('exception')->handleException($ErrorException);
        }
    }

    /**
     * Queue constructor.
     * @param array $param
     * @throws \Exception
     */
    public final function __construct($param = [])
    {
        if( $param ){
            $this->initParameters($param);
            $this->saveParams($param);
        }
    }

    protected function saveParams($param)
    {
        $this->allParams = $param;
    }

    public function getQueueName()
    {
        return $this->queueName;
    }

    public function getParams()
    {
        return $this->allParams;
    }

    protected function initParameters($param)
    {
        $config = [];
        foreach ($param as $key => $value) {
            if (is_numeric($key)){
                throw new \Exception('推入队列的参数必须使用数组并且明确参数名称');
            }
            $funName = strtolower($this->setPrefix . $key);
            $config  = $this->getSetFunction();
            if( isset($config[$funName]) ){
                $realFunName = $config[$funName]['name'];
                $this->{$realFunName}($value);
                unset($config[$funName]);
            }
        }
        if( $config ){
            foreach ($config as $funName => $value) {
                if( $value['optional'] ){
                    $paramName = str_replace($this->setPrefix,'',$value['name']);
                    throw new \Exception('参数名称:'.$paramName.'没有传入');
                }else{
                    $realFunName = $value['name'];
                    $this->{$realFunName}();
                }
            }
        }
    }

    protected function getSetFunction()
    {
        $ReflectionClass = new \ReflectionClass($this);
        $methods         = $ReflectionClass->getMethods();
        $allConfig       = [];
        foreach ($methods as $function) {
            if (strpos($function->getName(), $this->setPrefix) === 0) {
                $Parameters = $function->getParameters();
                foreach ($Parameters as $parameter) {
                    $funName = $function->getName();
                    if ($parameter->isOptional()) {
                        $optional = false;
                    } else {
                        $optional = true;
                    }
                    $allConfig[strtolower($funName)] = [
                        'optional'=>$optional,
                        'name'=>$funName
                    ];
                    break;
                }
            }
        }
        return $allConfig;
    }
}