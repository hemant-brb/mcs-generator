<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 23/08/18
 * Time: 6:55 PM
 */

namespace Devslane\Generator\Exceptions;


class HttpException extends \Symfony\Component\HttpKernel\Exception\HttpException
{
    public function __construct($message, $statusCode = 422) {
        parent::__construct($statusCode, $message);
    }
}
