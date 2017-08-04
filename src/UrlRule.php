<?php

namespace ZanPHP\Routing;

use ZanPHP\Contracts\Config\Repository;
use ZanPHP\Support\Arr;
use ZanPHP\Support\Dir;
use ZanPHP\Support\Singleton;

class UrlRule
{

    use Singleton;

    private static $rules = [];

    public static function loadRules()
    {
        $repository = make(Repository::class);
        $routeFiles = Dir::glob($repository->get('path.routing'), '*.routing.php');

        if (!$routeFiles) return false;

        foreach ($routeFiles as $file)
        {
            $route = include $file;
            if (!is_array($route)) continue;
            self::$rules = Arr::merge(self::$rules, $route);
        }
    }

    public static function getRules()
    {
        return self::$rules;
    }
}