<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-05-02
 * Time: 14:12
 */

namespace Devslane\Generator\Utils;


use Illuminate\Support\Facades\Config;

class ConfigHelper
{
    /**
     * @param $key
     * @return mixed
     */
    public static function get($key) {
        return Config::get('mcs-helper.' . $key);
    }

    /**
     * @param $class
     * @return mixed
     */
    public static function getNamespace($class) {
        return Config::get('mcs-helper.' . $class . '.namespace');
    }

    /**
     * @param $class
     * @return mixed
     */
    public static function excludes($class) {
        return Config::get('mcs-helper.' . $class . '.exclude');
    }

    /**
     * @param $class
     * @return mixed
     */
    public static function includes($class) {
        return Config::get('mcs-helper.' . $class . 'include');
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function service($string) {
        return Config::get('mcs-helper.service.' . $string);
    }

    /**
     * @return mixed
     */
    public static function username() {
        return Config::get('mcs-helper.username');
    }

    /**
     * @return mixed
     */
    public static function getBasePath() {
        return Config::get('mcs-helper.base_path');
    }

    /**
     * @param $string
     * @return string
     */
    public static function getFilePath($string) {
        return self::getBasePath() . '/' . Config::get('mcs-helper.' . $string . '.path');

    }

    /**
     * @return bool
     */
    public static function isProduction() {
        return Config::get('app.env') === 'production';
    }
}