<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-03-07
 * Time: 12:23
 */

namespace Devslane\Generator\Generators;

use Carbon\Carbon;
use Devslane\Generator\Utils\ConfigHelper;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Str;

/**
 * Class GenerateContract
 * @package Devslane\Generator\Generators
 *
 * @property-read $type
 * @property-read $skippedColumns
 */
class GenerateContract extends Generator
{
    protected $type;
    protected $skippedColumns = [];

    /**
     * GenerateContract constructor.
     * @param Table $table
     * @param $type
     * @throws \Exception
     */
    public function __construct(Table $table, $type) {
        $this->type           = $type;
        $this->skippedColumns = ConfigHelper::get('contract.exclude_columns');
        parent::__construct($table, 'contract');
    }

    public function setClassName($suffix = "Contract") {
        $this->className = Str::studly(Str::singular($this->table->getName()));
        $this->className = "$this->type$this->className";
        if ($suffix) {
            $this->className = "$this->className$suffix";
        }
    }

    /**
     * @param $template
     * @return mixed$this->template
     */
    public function fillTemplate() {
        $this->template = str_replace('{{date}}', Carbon::now()->toRssString(), $this->template);
        $this->template = str_replace('{{namespace}}', $this->namespace, $this->template);
        $this->template = str_replace('{{interface}}', $this->className, $this->template);
        $this->template = str_replace('{{body}}', $this->body, $this->template);
        $this->template = str_replace('{{user}}', $this->user, $this->template);
        return $this->template;
    }

    public function setBody() {
        $columns = $this->table->getColumns();
        $data    = "";
        if ($this->type != "List") {
            foreach ($columns as $key => $column) {
                if (in_array($key, $this->skippedColumns)) {
                    continue;
                }
                $fieldName = Str::studly($key);
                $data      .= "\tpublic function get$fieldName();\n\n";
                if ($this->type === 'Update') {
                    $data .= "\tpublic function has$fieldName();\n\n";
                }
            }
        }
        $this->body = "$data";
    }
}