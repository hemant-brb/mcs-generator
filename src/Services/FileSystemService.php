<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-03-07
 * Time: 13:04
 */

namespace Devslane\Generator\Services;


use Illuminate\Support\Facades\Config;

class FileSystemService
{
    public static function createFile($fileName, $fileDir, $content, $overwrite = false) {
        if (!is_dir($fileDir)) {
            try {
                mkdir($fileDir);
            } catch (\Exception $exception) {
                throw new \Exception("File wasn't created. Error: " . $exception->getMessage());
            }
        }
        $fileName = $fileDir . '/' . $fileName;
        if (!is_file($fileName) || Config::get('mcs-helper.overwrite') || $overwrite) {
            file_put_contents($fileName, $content);
            echo "$fileName created\n";
        }
    }
}