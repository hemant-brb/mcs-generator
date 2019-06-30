<?php
/**
 * Created by PhpStorm.
 * User: Shris
 * Date: 05-06-2019
 * Time: 17:21
 */

namespace Devslane\Generator\Console\Commands;


use Devslane\Generator\Generators\GeneratorManager;
use Illuminate\Console\Command;

class GenerateRequestCommand extends Command
{

    protected $config;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:request {tables*}
                                         {--skip-table= : Name of the table}
                                         {--overwrite= : Overwrite the previously generated data.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generates Requests for the tables provided in the command.";

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
        // fetch data from config file.
        $tables  = $this->argument('tables');
        $service = new GeneratorManager();
        $service->generateRequests($tables);
    }

}