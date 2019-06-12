<?php

namespace FasterPay;

class Exception extends \Exception
{
    public function __construct($message, $code = 0, $detail = '')
    {
        $this->message = $message;
        $this->code = $code;
        $this->detail = $detail;
    }

    public function getDetail()
    {
        return $this->detail;
    }
}
