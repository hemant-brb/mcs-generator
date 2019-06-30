<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-05-10
 * Time: 15:41
 */

namespace Devslane\Generator\Generators;


use Carbon\Carbon;
use Devslane\Generator\Services\FileSystemService;
use Devslane\Generator\Templates\TemplateService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class GenerateMigration
{
    const DATA_TYPES = [
        'string', 'integer', 'boolean', 'enum', 'text'
    ];

    const CONSTRAINTS = [
        'unique', 'nullable'
    ];


    public static function isValidType($type) {
        return Arr::exists(self::DATA_TYPES, $type);
    }


    public static function getFilePath() {
        return Config::get('mcs-helper.base_path') . '/' . Config::get('mcs-helper.migration.path');
    }

    /**
     * @param $table
     * @param array $data
     * @throws \Exception
     */
    public static function createMigrationForTable($table, array $data) {

        $tableName = Str::snake($table);

        $tablePrefix = Config::get('mcs-helper.migration.prefix');
        if (!empty($tablePrefix)) {
            $tableName = Str::snake($tablePrefix) . "_" . $tableName;
        }

        $className = str_replace('_', '', Str::title($tableName));
        $className = "Create$className" . "Table";

        $date     = Carbon::now();
        $month    = str_pad($date->month, 2, '0', STR_PAD_LEFT);
        $day      = str_pad($date->day, 2, '0', STR_PAD_LEFT);
        $hour     = str_pad($date->hour, 2, '0', STR_PAD_LEFT);
        $minute   = str_pad($date->minute, 2, '0', STR_PAD_LEFT);
        $second   = str_pad($date->second, 2, '0', STR_PAD_LEFT);
        $filename = $date->year . "_" . $month . "_" . $day . "_" . "$hour$minute$second" . "_create_" . $tableName . '_table';

        // generating class content.
        $template = TemplateService::getTemplate('migration');
        $template = str_replace('{{CLASS_NAME}}', $className, $template);
        $template = str_replace('{{table}}', $tableName, $template);
        $template = str_replace('{{COLUMNS}}', self::getColumnsBody($data), $template);

        // creating migration.
        FileSystemService::createFile($filename . '.php', self::getFilePath(), $template);
    }

    /**
     * @param array $columns
     * @return string
     */
    private static function getColumnsBody(array $columns) {
        $body = '';

        if (!empty($columns)) {
            foreach ($columns as $column) {

                $data = "\n\t\t\t";
                $name = $column['name'];
                $type = $column['type'];

                if (Str::contains($type, 'fk')) {
                    $type = explode('=', $type);
                    $fk   = $type[1];
                    $type = $type[0];
                }
                $constraints = $column['constraints'];
                switch ($type) {
                    case 'string':
                        $data .= '$table->string(\'' . $name . '\')';
                        break;
                    case 'integer':
                        $data .= '$table->integer(\'' . $name . '\')';
                        break;
                    case 'enum':
                        $data .= '$table->enum(\'' . $name . '\', [])';
                        break;
                    case 'boolean':
                        $data .= '$table->boolean(\'' . $name . '\')';
                        break;
                    case 'text':
                        $data .= '$table->text(\'' . $name . '\')';
                        break;
                    case 'fk':
                        $data .= '$table->unsignedBigInteger(\'' . $name . '\');' . "\n\t\t\t";
                        $data .= '$table->foreign(\'' . $name . '\')->references(\'id\')->on(\'' . $fk . '\')->onDelete(\'cascade\')';
                        break;
                    default :
                        $data .= '$table->string(\'' . $name . '\')';
                        break;
                }
                foreach ($constraints as $constraint) {
                    switch ($constraint) {
                        case 'unique':
                            $data .= '->unique()';
                            break;
                        case 'nullable':
                            $data .= '->nullable()';
                            break;
                    }
                }
                $body .= "$data;";
            }
        }

        return $body;
    }


}