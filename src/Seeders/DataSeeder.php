<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-05-17
 * Time: 19:11
 */


namespace Devslane\Generator\Seeders;

use Devslane\Generator\Services\ConfigHelper;
use Devslane\Generator\Services\Helpers;
use Carbon\Carbon;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


/**
 * Class DataSeeder
 * @package Devslane\Generator\Seeders
 *
 * @property-read Table $table
 * @property-read int $count
 *
 */
class DataSeeder
{
    protected $faker;
    protected $table;
    protected $count;
    protected $skipColumns = ['id', 'deleted_at', 'updated_at', 'created_at'];

    /**
     * DataSeeder constructor.
     */
    public function __construct() {
    }


    /**
     * @param $table
     * @param $count
     * @throws DBALException
     * @throws \Exception
     */
    public function seed($tableName, $count, $truncate = false) {

        $this->table = $this->getTable($tableName);
        $this->count = $count;

        if (ConfigHelper::isProduction() && $truncate) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table($tableName)->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        $data = $this->generateData();
    }


    /**
     * @param $tableName
     * @throws DBALException
     * @throws \Exception
     * @return Table
     */
    private function getTable($tableName) {
        $connection = DB::connection();
        $connection->getDoctrineSchemaManager()
            ->getDatabasePlatform()
            ->registerDoctrineTypeMapping('enum', 'string');
        $tables = $connection->getDoctrineSchemaManager()->listTables();

        $table = null;
        foreach ($tables as $t) {
            if ($t->getName() === $tableName) {
                $table = $t;
            }
        }

        if (!$table) {
            throw new \Exception("$tableName table not found");
        }

        return $table;
    }

    /**
     * @return array
     */
    private function generateData() {
        $data    = [];
        $columns = $this->table->getColumns();
        foreach ($columns as $column) {
            $name = $column->getName();
            if (in_array($name, $this->skipColumns)) {
                continue;
            }
            dd($column->getType()->getBindingType(), $column->getType()->getName());
            if (Str::contains($name, 'url') || Str::contains($name, 'website')) {
                $data[$name] = $this->getRandomUrl(!$column->getNotnull());
                continue;
            }
            $data[$name] = $this->getData($column);
        }
        return $data;
    }



    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     * @return mixed
     */
    private function getData(\Doctrine\DBAL\Schema\Column $column) {
        $type     = $column->getType()->getName();
        $nullable = !$column->getNotnull();
        $default  = $column->getDefault();
        switch ($type) {
            case "boolean":
                return $this->getRandomBoolean($nullable);
            case "integer":
                return $this->getRandomInt($nullable);
            case "bigint":
                return $this->getRandomInt($nullable);
            case "datetime":
                return $this->getRandomDateTime($nullable);
            case "date":
                return $this->getRandomDate($nullable);
            default:
                return $default ? $default : $this->getRandomString($nullable);
        }
    }

    private function getRandomBoolean(bool $nullable) {
        return Arr::random([0, 1]);
    }

    private function getRandomInt(bool $nullable) {
        return Arr::random([1, 1000]);
    }

    private function getRandomDate(bool $nullable) {
        return Carbon::now()->toDateString();
    }

    private function getRandomDateTime(bool $nullable) {
        return Carbon::now()->toDateTimeString();
    }

    private function getRandomString(bool $nullable) {
        return Helpers::generateUniqueId(10);
    }

    private function getRandomUrl(bool $param) {
        return "https://" . Helpers::generateUniqueId() . '.com/' . Helpers::generateUniqueId(15);
    }


}