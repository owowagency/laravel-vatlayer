<?php

namespace Vatlayer\Exceptions;

use Exception;

class RequestFailed extends Exception
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     *
     * @param  int  $code
     * @param  string  $message
     * @param  \Throwable  $previous
     */
    public function __construct($code = 0, $message = "", \Throwable $previous = null)
    {
        parent::__construct(
            'Request failed with the following code: ' . $this->code . '. Given message: ' . $message,
            $code,
            $previous
        );
    }
}
