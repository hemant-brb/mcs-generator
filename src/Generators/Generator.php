<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-05-29
 * Time: 12:38
 */

namespace Devslane\Generator\Generators;

use Devslane\Generator\Utils\ConfigHelper;
use Devslane\Generator\Services\FileSystemService;
use Devslane\Generator\Templates\TemplateService;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Str;

/**
 * Class Generator
 * @package Devslane\Generator\Generators
 * @property-read Table $table
 * @property-read string $className
 * @property-read string $namespace
 * @property-read string $parent
 * @property-read string $properties
 * @property-read string $template
 * @property-read string $user
 * @property-read string $filePath
 * @property-read string $model
 * @property-read string $generatortype
 * @property-read string $body
 */
abstract class Generator
{

    protected $namespace;
    protected $properties;
    protected $table;
    protected $template;
    protected $user;
    protected $filePath;
    protected $model;
    protected $className;
    protected $generatortype;
    protected $body;

    /**
     * Generator constructor.
     * @param Table $table
     * @param $generatorType
     * @throws \Exception
     */
    public function __construct(Table $table, $generatorType) {
        if(!ConfigHelper::isPublished()){
            throw new \Exception("The package is not published");
        }

        $this->table         = $table;
        $this->generatortype = $generatorType;

        $this->setModel();
        $this->setNameSpace();
        $this->setUser();
        $this->setClassName();
        $this->setFilePath();
        $this->setTemplate();
        $this->setBody();
        $this->fillTemplate();
    }

    /**
     * @throws \Exception
     */
    function create() {
        FileSystemService::createFile($this->className . '.php', $this->filePath, $this->template);
    }

    public function setBody() {
        $this->body = "";
    }

    abstract function fillTemplate();

    abstract function setClassName();

    /**
     * @throws \Exception
     */
    public function setTemplate() {
        $this->template = TemplateService::getTemplate($this->generatortype);
    }


    public function setFilePath() {
        $this->filePath = ConfigHelper::getFilePath($this->generatortype);
    }

    function setNameSpace() {
        $this->namespace = ConfigHelper::getNamespace($this->generatortype);
    }

    function setModel() {
        $this->model = Str::studly(Str::singular($this->table->getName()));
    }

    function setUser() {
        $this->user = ConfigHelper::username();
    }
}