<?php

namespace ShawnRong\Avocado\Controllers;

use App\Http\Controllers\Controller;
use Dingo\Api\Exception\ValidationHttpException;
use Dingo\Api\Routing\Helpers;

class BaseController extends Controller
{

    use Helpers;

    /*
     * Bad Request Handler
     * @param $validator
     */
    protected function errorBadRequest($validator)
    {
        $result   = [];
        $messages = $validator->errors()->toArray();

        if ($messages) {
            foreach ($messages as $field => $errors) {
                foreach ($errors as $error) {
                    $result [] = [
                        'field' => $field,
                        'code'  => $error,
                    ];
                }
            }
        }
        throw new ValidationHttpException($result);
    }
}
