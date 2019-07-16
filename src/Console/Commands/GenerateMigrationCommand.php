<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-02-14
 * Time: 14:37
 */

namespace Devslane\Generator\Console\Commands;

use Devslane\Generator\Generators\GenerateMigration;
use Illuminate\Console\Command;

class GenerateMigrationCommand extends Command
{

    protected $config;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:migration 
    {table : Name of the table}
    {--columns= : Columns of the table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generates Migration for the given table name and given columns.";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function handle() {

        $table       = $this->argument('table');
        $columnsData = [];

        $columns_info = $this->option('columns');

        if (!empty($columns_info)) {
            try {
                $columns_info = explode(',', $columns_info);
                foreach ($columns_info as $column) {
                    $column      = explode(':', $column);
                    $name        = $column[0];
                    $meta        = $column[1];
                    $meta        = explode('/', $meta);
                    $type        = $meta[0];
                    $constraints = [];
                    if (sizeof($meta) > 1) {
                        array_shift($meta);
                        foreach ($meta as $m) {
                            $constraints[] = $m;
                        }
                    }
                    $columnsData[] = [
                        'name'        => $name,
                        'type'        => $type,
                        'constraints' => $constraints
                    ];
                }
            } catch (\Exception $exception) {
                echo "Option columns has invalid data";
            }
        }

        GenerateMigration::createMigrationForTable($table, $columnsData);

    }


}