<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-05-16
 * Time: 19:32
 */

namespace Devslane\Generator\Generators;


use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

/**
 *
 * Class GenerateHelperDocs
 * @package Devslane\Generator\Services
 *
 * @property-read Table $table
 * @property-read string $file
 * @property-read string $fileContent
 */
class GenerateHelperDocs
{

    protected $table;
    protected $file;
    protected $fileContent;

    /**
     * GenerateHelperDocs constructor.
     * @param Table $table
     * @throws \Exception
     */
    public function __construct(Table $table) {
        $this->table       = $table;
        $this->file        = $this->getFile();
        $this->fileContent = $this->getFileContent();
    }

    public function generateIDEHelpersForModel() {
        if (!is_file($this->file)) {
            // Model doesn't exists. return;
            return;
        }

        $classContent  = 'class' . explode('class', $this->fileContent)[1];
        $meta          = explode('class', $this->fileContent)[0];
        $headerContent = explode('namespace App;', $meta)[0] . "namespace App;\n\n";
        $helperContent = explode('namespace App;', $meta)[1];

        $helperContent = $this->updateHelperContent($helperContent);

        file_put_contents($this->getFile(), "$headerContent$helperContent\n$classContent");
    }


    /**
     * @return string
     */
    private function getFilePath() {
        return Config::get('mcs-helper.base_path') . '/' . Config::get('mcs-helper.model.path');
    }

    /**
     * @return string
     */
    private function getClassName() {
        return Str::studly(Str::singular($this->table->getName()));
    }

    /**
     * @return string
     */
    private function getFile() {
        return $this->getFilePath() . '/' . $this->getClassName() . '.php';
    }


    /**
     * @return false|string
     * @throws \Exception
     */
    private function getFileContent() {
        $content = file_get_contents($this->file);
        return $content;
    }

    private function updateHelperContent($helperContent) {
        $helperContent = trim($helperContent);
        if (empty($helperContent)) {
            $helperContent = "/**\n * App/" . $this->getClassName() . "\n */";
        }
        $columns = $this->table->getColumns();

        foreach ($columns as $key => $column) {
            $property = "@property " . $this->getType($column->getType()->getName()) . " $" . $key;
            if (!Str::contains($helperContent, $property)) {
                $property      = " * " . $property;
                $helperContent = str_replace("*/", "$property\n*/", trim($helperContent));
            }
        }
        foreach ($columns as $key => $column) {
            $method = '@method static \Illuminate\Database\Eloquent\Builder|\App\\'
                . $this->getClassName()
                . ' where'
                . str_replace('_', '', Str::title($column->getName()))
                . '($value)';
            if (!Str::contains($helperContent, $method)) {
                $method        = " * " . $method;
                $helperContent = str_replace("*/", "$method\n*/", trim($helperContent));
            }
        }

        return $helperContent;
    }

    private function getType($type) {
        switch ($type) {
            case "integer":
                return "int";
            case "bigint":
                return "int";
            case "datetime":
                return "\Illuminate\Support\Carbon";
            default:
                return "string";
        }
    }

}