<?php


namespace Devslane\Generator\Controllers;

use Devslane\Generator\Requests\BaseRequest;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    use Helpers, DispatchesJobs;

    public function validate(BaseRequest $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            throw new ValidationHttpException($validator->errors());
        }
    }
}
