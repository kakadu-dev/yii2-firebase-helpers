<?php
/**
 * Created by PhpStorm.
 * User: mikhail
 * Date: 1/21/19
 * Time: 3:14 PM
 */

namespace Kakadu\Yii2Firebase;

/**
 * Class    FluentAbstract
 * @package Kakadu\Yii2Firebase
 * @author  Yarmaliuk Mikhail
 * @version 1.0
 */
abstract class FluentAbstract
{
    /**
     * @var bool
     */
    protected static $_methodNotExist = false;

    /**
     * Return self class for catch not exist method
     *
     * @return null
     */
    protected static function catchMethod()
    {
        static::$_methodNotExist = true;

        return new static();
    }

    /**
     * Detect not exist method calls
     *
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (!method_exists($this, $method) && static::$_methodNotExist) {
            return self::catchMethod();
        }

        return call_user_func_array([$this, $method], $args);
    }
}