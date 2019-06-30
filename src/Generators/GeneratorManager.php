<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-03-06
 * Time: 18:58
 */

namespace Devslane\Generator\Generators;


use Devslane\Generator\Services\ConfigHelper;
use Devslane\Generator\Services\DBService;
use Devslane\Generator\Services\Helpers;
use Doctrine\DBAL\Schema\Table;

/**
 * Class GeneratorManager
 * @package Devslane\Generator\Services
 *
 * @property-read array $excludes
 * @property-read array $includes
 */
class GeneratorManager
{
    private $excludes;
    private $includes;

    /**
     * @throws \Exception
     */
    public function generateAll($tables) {
        $this->includes = ConfigHelper::get('includes');
        $this->excludes = ConfigHelper::get('excludes');

        $allTables = DBService::getTables($tables);

        foreach ($allTables as $table) {
            if (Helpers::canWrite($table, $this->includes, $this->excludes)) {
                $this->generateContract($table);
                $this->generateController($table);
                $this->generateException($table);
                $this->generateFactory($table);
                $this->generateIdeHelperMethods($table);
                $this->generateModel($table, true);
                $this->generateTransformer($table);
                $this->generateRequest($table);
                $this->generateSeeder($table);
                $this->generateService($table);
            }
        }
    }


    /*                                                                                          *//*
     * ---------------------------------------------------------------------------------------  *
    *//*                                                                                        */


    /**
     * @param array $tables
     * @throws \Exception
     */
    public function generateContracts($tables = array()) {
        $this->includes = $tables;
        $this->excludes = [];

        $tables = DBService::getTables();

        foreach ($tables as $table) {
            $this->generateContract($table);
        }
    }


    /**
     * @param array $tables
     * @throws \Exception
     */
    public function generateControllers($tables = array()) {
        $this->includes = $tables;
        $this->excludes = [];

        $tables = DBService::getTables();

        foreach ($tables as $table) {
            $this->generateController($table);
        }
    }

    /**
     * @param array $tables
     * @throws \Exception
     */
    public function generateFactories($tables = array()) {
        $this->includes = $tables;
        $this->excludes = [];

        $tables = DBService::getTables();

        foreach ($tables as $table) {
            $this->generateFactory($table);
        }
    }


    /**
     * @param array $tables
     * @throws \Exception
     */
    public function generateExceptions($tables = array()) {
        $this->includes = $tables;
        $this->excludes = [];

        $tables = DBService::getTables();

        foreach ($tables as $table) {
            $this->generateException($table);
        }
    }

    /**
     * @param array $tables
     * @throws \Exception
     */
    public function generateModels($tables = array()) {
        $this->includes = $tables;
        $this->excludes = [];

        $tables = DBService::getTables();
        foreach ($tables as $table) {
            $this->generateModel($table);
        }
    }

    /**
     * @param array $tables
     * @throws \Exception
     */
    public function generateRequests($tables = array()) {
        $this->includes = $tables;
        $this->excludes = [];

        $tables = DBService::getTables();

        foreach ($tables as $table) {
            $this->generateRequest($table);
        }
    }


    /**
     * @param array $tables
     * @throws \Exception
     */
    public function generateSeeders($tables = array()) {
        $this->includes = $tables;
        $this->excludes = [];

        $tables = DBService::getTables();

        foreach ($tables as $table) {
            $this->generateSeeder($table);
        }
    }


    /**
     * @param array $tables
     * @throws \Exception
     */
    public function generateServices($tables = array()) {
        $this->includes = $tables;
        $this->excludes = [];

        $tables = DBService::getTables();

        foreach ($tables as $table) {
            $this->generateService($table);
        }
    }

    /**
     * @param array $tables
     * @throws \Exception
     */
    public function generatorTransformers($tables = array()) {
        $this->includes = $tables;
        $this->excludes = [];

        $tables = DBService::getTables();

        foreach ($tables as $table) {
            $this->generateTransformer($table);
        }
    }



    /*                                                                                          *//*
     * ---------------------------------------------------------------------------------------  *
    *//*                                                                                        */


    /**
     * @param Table $table
     * @throws \Exception
     */
    private function generateContract(Table $table) {
        if (!Helpers::isWriteable('contract', $table->getName())) {
            return;
        }
        $types = ConfigHelper::get('contract.types');
        foreach ($types as $type) {
            $contract = new GenerateContract($table, $type);
            $contract->create();
        }
    }


    /**
     * @param Table $table
     * @throws \Exception
     */
    private function generateController(Table $table) {
        if (!Helpers::isWriteable('controller', $table->getName())) {
            return;
        }
        $service = new GenerateController($table);
        $service->create();
    }

    /**
     * @param Table $table
     * @throws \Exception
     */
    private function generateException(Table $table) {
        if (!Helpers::isWriteable('exception', $table->getName())) {
            return;
        }
        $exception = new GenerateException($table);
        $exception->create();
    }


    /**
     * @param Table $table
     * @throws \Exception
     */
    private function generateFactory(Table $table) {
        if (!Helpers::isWriteable('factory', $table->getName())) {
            return;
        }
        $generator = new GenerateFactory($table);
        $generator->create();
    }

    /**
     * @param Table $table
     * @throws \Exception
     */
    private function generateIdeHelperMethods(Table $table) {
        if (!Helpers::isWriteable('model', $table->getName())) {
            return;
        }
        $model = new GenerateHelperDocs($table);
        $model->generateIDEHelpersForModel();
    }

    /**
     * @param Table $table
     * @param bool $withRelationalMethods
     * @throws \Exception
     */
    private function generateModel(Table $table, $withRelationalMethods = false) {
        if (!Helpers::isWriteable('model', $table->getName())) {
            return;
        }
        $model = new GenerateModel($table, $withRelationalMethods);
        $model->create();
    }


    /**
     * @param Table $table
     * @throws \Exception
     */
    private function generateRequest(Table $table) {
        if (!Helpers::isWriteable('request', $table->getName())) {
            return;
        }
        $types = ConfigHelper::get('request.types');
        foreach ($types as $type) {
            $request = new GenerateRequest($table, $type);
            $request->create();
        }
    }


    /**
     * @param Table $table
     * @throws \Exception
     */
    private function generateSeeder(Table $table) {
        if (!Helpers::isWriteable('seeder', $table->getName())) {
            return;
        }
        $generator = new GenerateSeeder($table);
        $generator->create();
    }

    /**
     * @param Table $table
     * @throws \Exception
     */
    private function generateService(Table $table) {
        if (!Helpers::isWriteable('service', $table->getName())) {
            return;
        }
        $service = new GenerateService($table);
        $service->create();
    }

    /**
     * @param Table $table
     * @throws \Exception
     */
    private function generateTransformer(Table $table) {
        if (!Helpers::isWriteable('transformer', $table->getName())) {
            return;
        }
        $transformer = new GenerateTransformer($table);
        $transformer->create();
    }


}