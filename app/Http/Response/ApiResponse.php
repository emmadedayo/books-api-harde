<?php
/*
* @author Adenagbe Emmanuel Adedayo
* @github https://github.com/emmadedayo
* @linkedIn https://www.linkedin.com/in/adenagbe-adedayo/
* @email emmadenagbe@gmail.com
* @project hardes
* @created Wed, Apr 2023
* @Time 2:45 pm
*/

namespace App\Http\Response;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Response;

class ApiResponse extends Controller
{

    protected $statusCode = IlluminateResponse::HTTP_OK;

    /** status code getter
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /** status code setter
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode): static
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param $data
     * @param array $headers
     * @return mixed
     */
    public function respond($data, array $headers = []): mixed
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotFound(string $message = 'Not found!'): mixed
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError([
            'message' => $message,
            'status_code' => $this->getStatusCode()
        ]);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondInternalError(string $message = 'Internal Error!'): mixed
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError([
            'message' => $message,
            'status_code' => $this->getStatusCode()
        ]);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondBadRequest(string $message = 'Internal Error!'): mixed
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_BAD_REQUEST)->respondWithError([
            'message' => $message,
            'status_code' => $this->getStatusCode()
        ]);
    }


    /**
     * @param $message
     * @return mixed
     */
    public function respondWithError($message): mixed
    {
        return $this->respond([
            'error' => $message
        ]);

    }

    /**
     * @param $message
     * @return mixed
     */
    public function respondCreated($message): mixed
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)->respond([
            'message' => $message,
            'status_code' => $this->getStatusCode()
        ]);
    }

    /**
     * @param $message
     * @return mixed
     */
    public function deletedResponse($message): mixed
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_OK)->respond([
            'status_code' => IlluminateResponse::HTTP_NO_CONTENT,
            'status' => 'success',
            'message' => $message,
            'data' => []
        ]);
    }


    /**
     * @param $data
     * @param string $message
     * @return mixed
     */
    public function respondWithNoPagination($data, string $message = 'Data fetched Successfully'): mixed
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_OK)->respond([
            'status_code' => $this->getStatusCode(),
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * @param $data
     * @param int $statusCode
     * @return mixed
     */
    public function respondWithDataStatusAndCodeOnly($data, $statusCode = IlluminateResponse::HTTP_OK): mixed
    {
        return $this->setStatusCode($statusCode)->respond([
            'status_code' => $this->getStatusCode(),
            'status' => 'success',
            'data' => $data
        ]);
    }

    /**
     * @param Validator $validator
     * @return array
     */
    function getErrorMessages(Validator $validator): array
    {
        $messages =  $validator->errors()->getMessages();
        $replaced = str_replace(['[',']', '"', '.','id'], '', json_encode(array_values($messages)));
        return explode(',',$replaced);
    }
}
