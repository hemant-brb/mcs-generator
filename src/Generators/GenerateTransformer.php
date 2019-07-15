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
 * @package Devslane\Generator\Generators
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
            if ($key === "created_at" || $key === "deleted_at" || $key === "updated_at") {
                continue;
            }
            switch ($column->getType()->getName()) {
                case IntegerType::INTEGER:
                    if ($column->getNotnull())
                        $data .= "\t\t\t'$key' => (int)$model->$key,\n";
                    else
                        $data .= "\t\t\t'$key' => HelperUtil::nullOrInteger($model->$key),\n";
                    break;
                case IntegerType::DATETIME:
                    $data .= "\t\t\t'$key' => $model->$key,\n";
                    break;
                case IntegerType::STRING:
                    $data .= "\t\t\t'$key' => $model->$key,\n";
                    break;
                case IntegerType::BOOLEAN:
                    if ($column->getNotnull())
                        $data .= "\t\t\t'$key' => (bool)$model->$key,\n";
                    else
                        $data .= "\t\t\t'$key' => HelperUtil::nullOrBool($model->$key),\n";
                    break;
                default:
                    $data .= "\t\t\t'$key' => $model->$key,\n";
            }
        }
        $this->body = "return [\n$data\t\t];";
    }
}