<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2017/12/22
 * Time: 14:41
 */

namespace Framework\Support\Listeners;


abstract class DatabaseListener
{
    /**
     * 当成功连接数据库之后触发
     */
    public function afterConnect()
    {
    }

    /**
     * 在发送SQL到数据库前触发
     */
    public function beforeQuery()
    {
    }

    /**
     * 在发送SQL到数据库执行后触发
     */
    public function afterQuery()
    {
    }

    /**
     * 在关闭一个暂存的数据库连接前触发
     */
    public function beforeDisconnect()
    {
    }

    /**
     * 事务启动前触发
     */
    public function beginTransaction()
    {
    }

    /**
     * 事务回滚前触发
     */
    public function rollbackTransaction()
    {
    }

    /**
     * 事务提交前触发
     */
    public function commitTransaction()
    {
    }
}