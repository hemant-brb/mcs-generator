<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-03-07
 * Time: 13:47
 */

namespace Devslane\Generator\Generators;


use Carbon\Carbon;
use Devslane\Generator\Services\FileSystemService;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;


/**
 * Class GenerateController
 * @package App\TEST
 *
 * @property-read Table $table
 * @property-read string $className
 * @property-read string $namespace
 * @property-read string $body
 * @property-read string $parent
 * @property-read string $properties
 * @property-read string $template
 * @property-read string $user
 * @property-read string $filePath
 * @property-read string $types
 * @property-read string $model
 * @property-read string $parentController
 */
class GenerateController extends Generator
{
    protected $parentController;

    /**
     * GenerateController constructor.
     * @param Table $table
     * @throws \Exception
     */
    public function __construct(Table $table) {
        if (empty(Config::get('mcs-helper.controller.parent'))) {
            throw new \Exception("Controller Parent not defined");
        }
        $this->parentController = Config::get('mcs-helper.controller.parent');
        parent::__construct($table, 'controller');
    }


    public function create() {
        $this->fillTemplate();
        FileSystemService::createFile($this->className . '.php', $this->filePath, $this->template);
    }

    public function setClassName($prefix = null, $suffix = "Controller") {
        $this->className = $this->model;
        if ($prefix) {
            $this->className = "$prefix$this->className";
        }
        if ($suffix) {
            $this->className = "$this->className$suffix";
        }
    }


    public function fillTemplate() {
        $this->template = str_replace('{{user}}', $this->user, $this->template);
        $this->template = str_replace('{{date}}', Carbon::now()->toRssString(), $this->template);
        $this->template = str_replace('{{namespace}}', $this->namespace, $this->template);
        $this->template = str_replace('{{model}}', $this->model, $this->template);
        $this->template = str_replace('{{class}}', $this->className, $this->template);
        $this->template = str_replace('{{body}}', $this->body, $this->template);
        $this->template = str_replace('{{Model}}', $this->model, $this->template);
        $this->template = str_replace('{{_model}}', strtolower($this->model), $this->template);
        $this->template = str_replace('{{var_service}}', $this->getServiceVariableName(), $this->template);
        $this->template = str_replace('{{ParentController}}', $this->parentController, $this->template);
    }

    private function getServiceVariableName() {
        $var = strtolower($this->model) . 'Service';
        return Str::length($var) > 20 ? 'service' : $var;
    }

    function setBody() {
        $this->body = "";
    }
}