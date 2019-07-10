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
    /**
     * @param $fileName
     * @param $fileDir
     * @param $content
     * @param bool $overwrite
     * @throws \Exception
     */
    public static function createFile($fileName, $fileDir, $content, $overwrite = false) {
        if (empty($fileDir)) {
            throw new \Exception("File path is required.");
        }
        if (empty($fileName)) {
            throw new \Exception("File name is required.");
        }
        if (!is_dir($fileDir)) {
            try {
                mkdir($fileDir, 0777, true);
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