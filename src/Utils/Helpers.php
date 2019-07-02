<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-05-29
 * Time: 12:31
 */

namespace Devslane\Generator\Utils;


use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Helpers
{
    /**
     * @param $tableName
     * @param null $suffix
     * @param null $prefix
     * @return string
     */
    public static function getClassName($tableName, $suffix = null, $prefix = null) {
        $className = Str::studly(Str::singular($tableName));
        if ($prefix) {
            $className = "$prefix$className";
        }
        if ($suffix) {
            $className = "$className$suffix";
        }
        return $className;
    }


    /**
     * @param Column $column
     * @param Table $table
     * @return string
     */
    public static function getFakerType(Column $column, Table $table) {
        $type  = $column->getType()->getName();
        $field = $column->getName();
        switch ($field) {
            case "first_name":
                return "firstName";
            case "last_name":
                return "lastName";
            case "email":
                return "email";
            case "password":
                return "password";
            case "phone":
                return "phoneNumber";
            case "address_line_1":
                return "address";
            case "address_line_2":
                return "address";
            case "city":
                return "city";
            case "state":
                return "state";
            case "zip_code":
                return "randomNumber(6)";
            case "created_at":
                return "dateTime";
            case "updated_at":
                return "dateTime";
            case "deleted_at":
                return null;
        }
        switch ($type) {
            case "boolean":
                return "boolean";
            case "integer":
                return "numberBetween(0,100)";
            case "bigint":
                $localColumn = null;
                $referTable  = null;
                $referCol    = null;
                foreach ($table->getForeignKeys() as $foreignKey) {
                    if (in_array($column->getName(), $foreignKey->getColumns())) {
                        $localColumn = $foreignKey->getColumns()[0];
                        $referTable  = $foreignKey->getForeignTableName();
                        $referCol    = $foreignKey->getForeignColumns()[0];
                        break;
                    }
                }
                if ($localColumn) {
                    $modelName = Str::studly(Str::singular($referTable));
                    return 'randomElement(App\\' . $modelName . '::pluck("' . $referCol . '")->toArray())';
                }
                return "numberBetween(0,100)";
            case "datetime":
                return "dateTime";
            case "date":
                return "date()";
            case "string":
                if ($column->getLength() == '0') {  // Case ENUM
                    $tableName = $table->getName();
                    $enum      = DB::select('SHOW FULL COLUMNS from ' . $tableName . ' LIKE ' . '"' . $column->getName() . '"')[0]->Type;
                    $len       = Str::length($enum);
                    $types     = Str::substr($enum, 5, $len - 6);
                    return 'randomElement([' . $types . '])';
                } else {
                    return "sentence(10)";
                }
            default:
                return "word";
        }
    }

    public static function isWriteable($type, $tableName) {
        $includes = ConfigHelper::includes($type);
        $excludes = ConfigHelper::excludes($type);

        $writeable = Helpers::canWrite($tableName, $includes, $excludes);
        if (!$writeable) {
            echo "Not allowed to write into file for $tableName $type";
        }
        return $writeable;
    }

    public static function canWrite($tableName, $includes, $excludes) {
        $isExcluded = false;
        $isIncluded = false;
        if (empty($excludes)) {
            $isExcluded = false;
        } else if (is_array($excludes) && in_array($tableName, $excludes)) {
            $isExcluded = true;
        }
        if (empty($includes)) {
            $isIncluded = true;
        } elseif (is_array($includes) && in_array($tableName, $includes)) {
            $isIncluded = true;
        }
        return !$isExcluded && $isIncluded;
    }

    public static function generateUniqueId($length = 9, $start = 'z') {
        return $start . Str::lower(Str::random($length - 1));
    }
}