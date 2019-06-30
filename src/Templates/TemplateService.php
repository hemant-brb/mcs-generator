<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-03-07
 * Time: 13:28
 */

namespace Devslane\Generator\Templates;


class TemplateService
{
    public static function getTemplate($name) {
        $path        = implode([__DIR__, '/', $name]);
        $fileContent = file_get_contents($path);
        if (empty($fileContent)) {
            throw new \Exception('requested template not found!');
        }
        return $fileContent;
    }
}