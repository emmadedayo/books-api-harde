<?php
/*
* @author Adenagbe Emmanuel Adedayo
* @github https://github.com/emmadedayo
* @linkedIn https://www.linkedin.com/in/adenagbe-adedayo/
* @email emmadenagbe@gmail.com
* @project hardes
* @created Wed, Apr 2023
* @Time 3:36 pm
*/

namespace App\Traits;

use App\Http\Response\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

trait ValidationTrait {

    /**
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        $response = [
            'status' => false,
            'message' => (new ApiResponse)->getErrorMessages($validator),
            'data' => [],
            'status_code' => 400
        ];
        throw new HttpResponseException(response($response,400));
    }
}
