<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-02-14
 * Time: 14:37
 */

namespace Devslane\Generator\Console\Commands;

use Devslane\Generator\Generators\GeneratorManager;
use Illuminate\Console\Command;

class GenerateSetupCommand extends Command
{

    protected $config;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:all {tables*}
                                         {--skip-table= : Name of the table}
                                         {--overwrite= : Overwrite the previously generated data.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generates Models, Controllers, Services, 
                              Request, Seeders, Contracts Exceptions and 
                              Transformers for the tables provided in the command.";

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
        $tables  = $this->argument('tables');

        $service = new GeneratorManager();
        $service->generateAll($tables);
    }

}