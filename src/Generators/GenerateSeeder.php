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
 * Class GenerateSeeder
 * @package Devslane\Generator\Generators
 */
class GenerateSeeder extends Generator
{
    const GENERATOR_TYPE = 'seeder';

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
    public function fillTemplate() {
        $this->template = str_replace('{{Model}}', $this->model, $this->template);
        return $this->template;
    }


    public function setClassName() {
        $this->className = Helpers::getClassName($this->table->getName(), 'sTableSeeder', null);
    }

    function setBody() {
        $this->body .= "";
    }
}