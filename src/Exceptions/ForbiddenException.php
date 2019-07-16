<?php
/**
 * Created by PhpStorm.
 * User: hemant
 * Date: 2019-01-02
 * Time: 13:53
 */

namespace Devslane\Generator\Exceptions;


class ForbiddenException extends HttpException
{
    const ERROR_MESSAGE = "You do not have right access to perform the requested operation.";

    public function __construct($message = null)
    {
        if (is_null($message)) {
            $message = self::ERROR_MESSAGE;
        }
        parent::__construct($message,  403);
    }
}