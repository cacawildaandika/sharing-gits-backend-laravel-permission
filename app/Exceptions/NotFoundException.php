<?php

namespace App\Exceptions;

use App\Helpers\BasicResponse;
use Exception;

class NotFoundException extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        $response = new BasicResponse();
        return $response
            ->setStatusCode(404)
            ->setMessage($this->getMessage())
            ->send();
    }
}
