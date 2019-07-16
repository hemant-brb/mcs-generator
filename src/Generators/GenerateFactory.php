<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-05-26
 * Time: 11:41
 */

namespace Devslane\Generator\Generators;


use Devslane\Generator\Utils\Helpers;
use Doctrine\DBAL\Schema\Table;

/**
 * Class GenerateFactory
 * @package Devslane\Generator\Generators
 */
class GenerateFactory extends Generator
{

    const GENERATOR_TYPE = 'factory';

    /**
     * GenerateFactory constructor.
     * @param Table $table
     * @throws \Exception
     */
    public function __construct(Table $table) {
        parent::__construct($table, self::GENERATOR_TYPE);
    }


    /**
     * @return mixed|string
     * @throws \Exception
     */
    public function fillTemplate()  {
        $this->template = str_replace('{{Model}}', $this->model, $this->template);
        $this->template = str_replace('{{body}}', $this->body, $this->template);
        return $this->template;
    }


    public function setClassName() {
        $this->className = Helpers::getClassName($this->table->getName(), 'Factory', null);
    }

    function setBody() {
        $this->body = "return [\n";

        $columns = $this->table->getColumns();
        foreach ($columns as $key => $column) {
            if ($key === 'id' || (($fakerType = Helpers::getFakerType($column, $this->table)) === null))
                continue;
            $this->body .= "\t\t'$key'=>" . '$faker->' . $fakerType . ',' . "\n";
        }
        $this->body .= "\t];";
    }

}