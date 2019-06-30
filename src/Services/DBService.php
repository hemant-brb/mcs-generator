<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-06-14
 * Time: 12:39
 */

namespace Devslane\Generator\Services;


use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Facades\DB;

class DBService
{
    /**
     * @return Table[]
     */
    public static function getTables() {
        $connection = DB::connection();
        try {
            $connection->getDoctrineSchemaManager()
                ->getDatabasePlatform()
                ->registerDoctrineTypeMapping('enum', 'string');
        } catch (DBALException $e) {
        }
        if (func_num_args() == 0) {
            return $connection->getDoctrineSchemaManager()->listTables();
        }
        $allTables = func_get_arg(0);
        $tables    = [];
        foreach ($allTables as $table) {
            array_push($tables, $connection->getDoctrineSchemaManager()->listTableDetails($table));
        }
        return $tables;
    }
}