<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-03-07
 * Time: 12:23
 */

namespace Devslane\Generator\Generators;


use Carbon\Carbon;
use Devslane\Generator\Services\FileSystemService;
use Devslane\Generator\Templates\TemplateService;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;


/**
 * Class GenerateRequest
 * @package App\TEST
 *
 * @property-read string $contractName
 * @property-read string $parentRequest
 */
class GenerateRequest extends Generator
{
    protected $contractName;
    protected $parentRequest;
    protected $type;

    /**
     * GenerateRequest constructor.
     * @param Table $table
     * @param $type
     * @throws \Exception
     */
    public function __construct(Table $table, $type) {
        $this->type = $type;
        if (!$this->type == "List") {
            $this->parentRequest = Config::get('mcs-helper.request.parent');
        } else {
            $this->parentRequest = Config::get('mcs-helper.request.list_parent');
        }
        parent::__construct($table, 'request');
        if ($this->type == "List") {
            FileSystemService::createFile('ListRequest.php',$this->filePath,TemplateService::getTemplate('list_request'));
        }

    }

    public function setClassName($suffix = "Request") {
        $this->className = Str::studly(Str::singular($this->table->getName()));
        $this->className = "$this->type$this->className";
        if ($suffix) {
            $this->className = "$this->className$suffix";
        }
        $this->contractName = str_replace('Request', 'Contract', $this->className);
        $contractPath       = Config::get('mcs-helper.contract.namespace');
        $this->contractName = $contractPath . '\\' . $this->contractName;
    }



    public function fillTemplate() {
        $this->template = str_replace('{{user}}', $this->user, $this->template);
        $this->template = str_replace('{{date}}', Carbon::now()->toRssString(), $this->template);
        $this->template = str_replace('{{namespace}}', $this->namespace, $this->template);
        $this->template = str_replace('{{contract}}', $this->contractName, $this->template);
        $this->template = str_replace('{{class}}', $this->className, $this->template);
        $this->template = str_replace('{{body}}', $this->body, $this->template);
        $this->template = str_replace('{{ParentRequest}}', $this->parentRequest, $this->template);
    }

    /**
     * @throws \Exception
     */
    public function setBody() {
        $methods   = "";
        $constants = "";
        if ($this->type != "List") {
            $columns = $this->table->getColumns();
            foreach ($columns as $key => $column) {
                if ($key === 'id') {
                    continue;
                }
                $const                 = Str::upper(Str::snake($key));
                $requestConstTemplate  = TemplateService::getTemplate('request_const');
                $requestConstTemplate  = str_replace('{{CONST}}', $const, $requestConstTemplate);
                $requestConstTemplate  = str_replace('{{key}}', "'$key'", $requestConstTemplate);
                $constants             .= $requestConstTemplate;
                $requestMethodTemplate = TemplateService::getTemplate('request_method');
                $requestMethodTemplate = str_replace('{{function_type}}', 'get', $requestMethodTemplate);
                $requestMethodTemplate = str_replace('{{method_type}}', 'input', $requestMethodTemplate);
                $requestMethodTemplate = str_replace('{{Field}}', Str::studly($key), $requestMethodTemplate);
                $requestMethodTemplate = str_replace('{{CONST}}', $const, $requestMethodTemplate);
                $methods               .= $requestMethodTemplate;
                if ($this->type === 'Update') {
                    $requestMethodTemplate = str_replace('get', 'has', $requestMethodTemplate);
                    $requestMethodTemplate = str_replace('input', 'has', $requestMethodTemplate);
                    $methods               .= $requestMethodTemplate;
                }
            }
            $this->body = "$constants\n\n$methods";
        } else {
            $this->body = "";
        }
    }
}