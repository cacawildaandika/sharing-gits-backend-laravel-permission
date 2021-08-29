<?php

namespace App\Helpers;

class BasicResponse
{
    private $statusCode, $message, $data;

    public function __construct($statusCode = 200, $message = 'Success', $data = null)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * @param int|mixed $statusCode
     */
    public function setStatusCode($statusCode): BasicResponse
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param mixed|string $message
     */
    public function setMessage($message): BasicResponse
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param mixed|null $data
     */
    public function setData($data): BasicResponse
    {
        $this->data = $data;
        return $this;
    }

    public function send(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'code' => $this->statusCode,
            'status' => $this->statusCode == 200 || $this->statusCode == 201 ? 'success' : 'fail',
            'message' => $this->message,
            'data' => $this->data,
        ], $this->statusCode);
    }
}
