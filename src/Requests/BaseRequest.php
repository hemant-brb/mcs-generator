<?php


namespace Devslane\Generator\Requests;

use Dingo\Api\Http\Request;

class BaseRequest extends Request {
    public function authorize() {
        return true;
    }


    public function rules() {
        return [

        ];
    }

    public function messages() {
        return [

        ];
    }
}