<?php
namespace App\Helpers;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResponseUtil{
    public static function createResponse($status, $data = [], $message = '') {
        return new JsonResponse([
            'status' => $status,
            'data' => $data,
            'message' => $message,
        ]);
    }
}

