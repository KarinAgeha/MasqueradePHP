<?php

namespace Masquerade;

use Latte;

abstract class Masquerade
{
    private static Latte $latte;
    private static array $resolvedInstances = [];

    public static abstract function getIdentity(): string;

    public static function bootAnalyzer(Latte $latte)
    {
        static::$resolvedInstances = $latte->getInstances();
        static::$latte = $latte;
    }

    public static function getClassIdentity()
    {
        return static::resolveCoreClass(static::whoAmI());
    }

    public static function whoAmI()
    {
        return static::getIdentity();
    }

    private static function resolveCoreClass(object | string $name)
    {
        if(is_object($name)) return $name;
        if(isset(static::$resolvedInstances[$name])) return static::$resolvedInstances;

        return self::$resolvedInstances[$name] = static::$latte->ignite($name);
    }

    public static function __callStatic($method, $args)
    {
        $instance = static::getClassIdentity();

        return $instance->$method(...$args);
    }
}
