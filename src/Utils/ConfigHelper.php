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

    const CONFIG_FILE = 'mcs-helper';

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key) {
        return Config::get(self::CONFIG_FILE . '.' . $key);
    }

    /**
     * @param $class
     * @return mixed
     */
    public static function getNamespace($class) {
        return Config::get(self::CONFIG_FILE . '.' . $class . '.namespace');
    }

    /**
     * @param $class
     * @return mixed
     */
    public static function excludes($class) {
        return Config::get(self::CONFIG_FILE . '.' . $class . '.exclude');
    }

    /**
     * @param $class
     * @return mixed
     */
    public static function includes($class) {
        return Config::get(self::CONFIG_FILE . '.' . $class . 'include');
    }

    /**
     * @param $string
     * @return mixed
     */
    public static function service($string) {
        return Config::get(self::CONFIG_FILE .'.service.' . $string);
    }

    /**
     * @return mixed
     */
    public static function username() {
        return Config::get(self::CONFIG_FILE .'.username');
    }

    /**
     * @return mixed
     */
    public static function getBasePath() {
        return Config::get(self::CONFIG_FILE .'.base_path');
    }

    /**
     * @param $string
     * @return string
     */
    public static function getFilePath($string) {
        return self::getBasePath() . '/' . Config::get(self::CONFIG_FILE . '.' . $string . '.path');

    }

    /**
     * @return bool
     */
    public static function isProduction() {
        return Config::get('app.env') === 'production';
    }
}