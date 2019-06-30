<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-02-17
 * Time: 01:14
 */

namespace Devslane\Generator\Generators;


use Carbon\Carbon;
use Devslane\Generator\Services\ConfigHelper;
use Devslane\Generator\Services\FileSystemService;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Str;

/**
 * Class GenerateModel
 * @package App\TEST
 *
 * @property-read boolean $withRtnMethods
 */
class GenerateModel extends Generator
{
    protected $withRtnMethods;

    /**
     * GenerateModel constructor.
     * @param Table $table
     * @param $withRelationalMethods
     * @throws \Exception
     */
    public function __construct(Table $table, $withRelationalMethods) {
        $this->parent         = ConfigHelper::get('model.parent');
        $this->withRtnMethods = $withRelationalMethods;
        parent::__construct($table, 'model');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getClassName() {
        $className = $this->className ? $this->className : $this->className = Str::studly(Str::singular($this->table->getName()));
        if (is_null($className)) {
            throw  new \Exception('Class name is not defined');
        }
        return $className;
    }

    /**
     * @param string $className
     */
    public function setClassName() {
        $this->className = Str::studly(Str::singular($this->table->getName()));;
    }

    /**
     * @return string
     */
    public function getProperties() {
        return $this->properties;
    }

    /**
     * @param string $properties
     */
    public function setProperties($properties): void {
        $this->properties = $properties;
    }


    /**
     * @throws \Exception
     */
    public function create() {
        $content = $this->fillTemplate();
        if ($this->withRtnMethods) {
            $content = $this->addRelationalMethods($content);
        }
        FileSystemService::createFile($this->getClassName() . '.php', $this->filePath, $content);
    }

    /**
     * @return mixed|string
     * @throws \Exception
     */
    public function fillTemplate() {
        $this->template = str_replace('{{date}}', Carbon::now()->toRssString(), $this->template);
        $this->template = str_replace('{{namespace}}', $this->namespace, $this->template);
        $this->template = str_replace('{{parent}}', $this->parent, $this->template);
        $this->template = str_replace('{{properties}}', $this->getProperties(), $this->template);
        $this->template = str_replace('{{class}}', $this->getClassName(), $this->template);
        $this->template = str_replace('{{user}}', $this->user, $this->template);
        $this->template = str_replace('{{body}}', $this->body, $this->template);
        return $this->template;
    }

    private function addRelationalMethods($template) {
        $methods  = "";
        $template = str_replace('{{body}}', $methods, $template);
        return $template;
    }

    function setBody() {
        $this->body = "";
    }
}