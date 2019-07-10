<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-07-10
 * Time: 18:52
 */

namespace Devslane\Generator\Services\Contracts;


interface ListContract
{
    public function getLimit();

    public function getOrder();

    public function getOrderBy();

    public function getSearchQuery();
}