<?php


namespace Devslane\Generator\Requests;

use Dingo\Api\Http\FormRequest;

/**
 * Class BaseRequest
 * @package Devslane\Generator\Requests
 */
class BaseRequest extends FormRequest
{
    public function authorize() {
        return true;
    }
}