<?php
/**
 * Created by PhpStorm.
 * User: 明月有色
 * Date: 2018/1/17
 * Time: 16:50
 */

namespace Framework\Support\Containers;


use Phalcon\Di;

class EventContainer implements FacadeInterface
{
    use Container;

    /**
     * 映射实体类
     *
     * @return string|object
     */
    public static function getFacadesAccessor()
    {
        return Di::getDefault()->getShared('event');
    }
}