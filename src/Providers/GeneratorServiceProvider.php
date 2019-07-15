<?php

namespace Devslane\Generator\Providers;

use Devslane\Generator\Console\Commands\GenerateContractCommand;
use Devslane\Generator\Console\Commands\GenerateControllerCommand;
use Devslane\Generator\Console\Commands\GenerateExceptionCommand;
use Devslane\Generator\Console\Commands\GenerateFactoryCommand;
use Devslane\Generator\Console\Commands\GenerateMigrationCommand;
use Devslane\Generator\Console\Commands\GenerateModelCommand;
use Devslane\Generator\Console\Commands\GenerateRequestCommand;
use Devslane\Generator\Console\Commands\GenerateSeederCommand;
use Devslane\Generator\Console\Commands\GenerateServiceCommand;
use Devslane\Generator\Console\Commands\GenerateSetupCommand;
use Devslane\Generator\Console\Commands\GenerateTransformerCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Class GeneratorServiceProvider
 * @package Devslane\Generator\Providers
 */
class GeneratorServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     *
     * Register your package's Artisan commands with Laravel. Once the commands have been registered, you may execute them using the Artisan CLI:
     *
     * @var array
     */
    protected $commandsToRegister = [
        GenerateContractCommand::class,
        GenerateControllerCommand::class,
        GenerateExceptionCommand::class,
        GenerateFactoryCommand::class,
        GenerateMigrationCommand::class,
        GenerateModelCommand::class,
        GenerateRequestCommand::class,
        GenerateSeederCommand::class,
        GenerateServiceCommand::class,
        GenerateSetupCommand::class,
        GenerateTransformerCommand::class
    ];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot() {

        $this->publishConfig();

        $this->publishCommands();
    }


    public function publishConfig() {
        $configPath = __DIR__ . '/../../config/mcs-helper.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('mcs-helper.php');
        } else {
            $publishPath = base_path('config/mcs-helper.php');
        }

        $this->publishes([$configPath => $publishPath], 'config');
    }

    public function publishCommands() {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commandsToRegister);
        }
    }


}
