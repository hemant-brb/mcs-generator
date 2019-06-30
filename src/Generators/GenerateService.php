<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-03-07
 * Time: 13:47
 */

namespace Devslane\Generator\Generators;


use Carbon\Carbon;
use Devslane\Generator\Services\ConfigHelper;
use Devslane\Generator\Services\FileSystemService;
use Devslane\Generator\Templates\TemplateService;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Str;


/**
 * Class GenerateService
 * @package App\TEST
 *
 * @property-read Table $table
 * @property-read string $className
 * @property-read string $namespace
 * @property-read string $parent
 * @property-read string $properties
 * @property-read string $template
 * @property-read string $user
 * @property-read string $filePath
 * @property-read string $types
 * @property-read string $model
 */
class GenerateService extends Generator
{
    /**
     * GenerateRequest constructor.
     * @param Table $table
     */
    public function __construct(Table $table) {
        parent::__construct($table, 'service');
    }


    /**
     * @throws \Exception
     */
    public function create() {
        $template = $this->fillTemplate();
        FileSystemService::createFile($this->className . '.php', $this->filePath, $template);
    }

    public function setClassName($prefix = null, $suffix = "Service") {
        $this->className = $this->model;
        if ($prefix) {
            $this->className = "$prefix$this->className";
        }
        if ($suffix) {
            $this->className = "$this->className$suffix";
        }
    }


    /**
     * @return mixed|string
     * @throws \Exception
     */
    public function fillTemplate() {
        $this->template = str_replace('{{user}}', $this->user, $this->template);
        $this->template = str_replace('{{date}}', Carbon::now()->toRssString(), $this->template);
        $this->template = str_replace('{{namespace}}', $this->namespace, $this->template);
        $this->template = str_replace('{{model}}', $this->model, $this->template);
        $this->template = str_replace('{{class}}', $this->className, $this->template);
        $this->template = str_replace('{{create_body}}', $this->getCreateBody(), $this->template);
        $this->template = str_replace('{{update_body}}', $this->getUpdateBody(), $this->template);
        $this->template = str_replace('{{Model}}', $this->model, $this->template);
        $this->template = str_replace('{{_model}}', strtolower($this->model), $this->template);
        return $this->template;
    }


    /**
     * @return string
     * @throws \Exception
     */
    protected function getUpdateBody() {
        $columns = $this->table->getColumns();
        $methods = "";
        foreach ($columns as $key => $column) {
            if (in_array($key, ConfigHelper::service('skip_update_fields'))) {
                continue;
            }
            $template = TemplateService::getTemplate('service_method');
            $template = str_replace('{{_model}}', strtolower($this->model), $template);
            $template = str_replace('{{_field}}', Str::snake($key), $template);
            $template = str_replace('{{Field}}', Str::studly($key), $template);
            $methods  .= $template;
        }
        return "$methods";
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function getCreateBody() {
        $columns = $this->table->getColumns();
        $methods = "";
        foreach ($columns as $key => $column) {
            if (in_array($key, ConfigHelper::service('skip_create_fields'))) {
                continue;
            }
            $template = TemplateService::getTemplate('service_create');
            $template = str_replace('{{_model}}', strtolower($this->model), $template);
            $template = str_replace('{{_field}}', Str::snake($key), $template);
            $template = str_replace('{{Field}}', Str::studly($key), $template);
            $methods  .= $template;
        }
        return "$methods";
    }
}