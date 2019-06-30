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
use Doctrine\DBAL\Types\IntegerType;


/**
 * Class GenerateTransformer
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
class GenerateTransformer extends Generator
{
    /**
     * GenerateTransformer constructor.
     * @param Table $table
     * @throws \Exception
     */
    public function __construct(Table $table) {
        parent::__construct($table, 'transformer');
    }


    /**
     * @throws \Exception
     */
    public function create() {
        $this->setBody();
        $template = $this->fillTemplate();
        FileSystemService::createFile($this->className . '.php', $this->filePath, $template);
    }

    public function setClassName($prefix = null, $suffix = "Transformer") {
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
        $this->template = str_replace('{{user}}', $this->user, $this->template);
        $this->template = str_replace('{{date}}', Carbon::now()->toRssString(), $this->template);
        $this->template = str_replace('{{namespace}}', $this->namespace, $this->template);
        $this->template = str_replace('{{model}}', $this->model, $this->template);
        $this->template = str_replace('{{class}}', $this->className, $this->template);
        $this->template = str_replace('{{body}}', $this->body, $this->template);
        $this->template = str_replace('{{Model}}', $this->model, $this->template);
        $this->template = str_replace('{{_model}}', strtolower($this->model), $this->template);
        return $this->template;
    }

    public function setBody() {
        $columns = $this->table->getColumns();
        $data    = "";
        $model   = '$' . strtolower($this->model);
        foreach ($columns as $key => $column) {
            if ($column->getNotnull()) { // is not nullable
                // TODO
            }
            switch ($column->getType()->getName()) {
                case IntegerType::INTEGER:
                    $data .= "\t\t\t'$key' => (int)$model->$key,\n";
                    break;
                case IntegerType::DATETIME:
                    $data .= "\t\t\t'$key' => $model->$key,\n";
                    break;
                case IntegerType::STRING:
                    $data .= "\t\t\t'$key' => $model->$key,\n";
                    break;
                case IntegerType::BOOLEAN:
                    $data .= "\t\t\t'$key' => (bool)$model->$key,\n";
                    break;
                default:
                    $data .= "\t\t\t'$key' => $model->$key,\n";
            }
        }
        $this->body = "return [\n$data\t\t];";
    }
}