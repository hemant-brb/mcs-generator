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


/**
 * Class GenerateException
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
 */
class GenerateException extends Generator
{

    /**
     * GenerateException constructor.
     * @param Table $table
     * @throws \Exception
     */
    public function __construct(Table $table) {
        parent::__construct($table, 'exception');
    }

    public function create() {
        $template = $this->fillTemplate();
        FileSystemService::createFile($this->className . '.php', $this->filePath, $template);
    }

    public function setClassName($prefix = null, $suffix = "NotFoundException") {
        $this->className = $this->model;
        if ($prefix) {
            $this->className = "$prefix$this->className";
        }
        if ($suffix) {
            $this->className = "$this->className$suffix";
        }
    }


    /**
     * @param $template
     * @return mixed
     */
    public function fillTemplate() {
        $template = $this->template;
        $template = str_replace('{{user}}', $this->user, $template);
        $template = str_replace('{{date}}', Carbon::now()->toRssString(), $template);
        $template = str_replace('{{namespace}}', $this->namespace, $template);
        $template = str_replace('{{model}}', $this->model, $template);
        $template = str_replace('{{class}}', $this->className, $template);
        $template = str_replace('{{body}}', $this->body, $template);
        return $template;
    }

    function setBody() {
        $this->body = "";
    }
}