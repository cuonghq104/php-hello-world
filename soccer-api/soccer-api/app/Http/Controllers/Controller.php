<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Info(title="Soccer api documentation", version="0.1")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sendResponse($data, $message = MESSAGE_RESPONSE_SUCCESS, $code = Response::HTTP_OK) {
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $code);
    }

    public function createSuccess($data) {
        return $this->sendResponse($data, message: MESSAGE_CREATE_SUCCESS , code: Response::HTTP_CREATED);
    }

    public function updateSuccess($data) {
        return $this->sendResponse($data, message: MESSAGE_UPDATE_SUCCESS , code: Response::HTTP_OK);
    }

    public function deleteSuccess($data) {
        return $this->sendResponse($data, message: MESSAGE_DELETE_SUCCESS , code: Response::HTTP_NO_CONTENT);
    }

    protected function responseError($data, $message = 'Error', $code = Response::HTTP_BAD_REQUEST) {
        return $this->sendResponse($data, $message, $code);
    }
}
