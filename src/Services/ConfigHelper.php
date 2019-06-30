<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-05-02
 * Time: 14:12
 */

namespace Devslane\Generator\Services;


use Illuminate\Support\Facades\Config;

class ConfigHelper
{
    public static function get($key) {
        return Config::get('mcs-helper.' . $key);
    }

    public static function getNamespace($class) {
        return Config::get('mcs-helper.' . $class . '.namespace');
    }

    public static function excludes($class) {
        return Config::get('mcs-helper.' . $class . '.exclude');
    }

    public static function includes($class) {
        return Config::get('mcs-helper.' . $class . 'include');
    }

    public static function service($string) {
        return Config::get('mcs-helper.service.' . $string);
    }

    public static function username() {
        return Config::get('mcs-helper.username');
    }

    public static function getBasePath() {
        return Config::get('mcs-helper.base_path');
    }

    public static function getFilePath($string) {
        return self::getBasePath() . '/' . Config::get('mcs-helper.' . $string . '.path');

    }

    public static function isProduction() {
        return Config::get('app.env') === 'production';
    }
}