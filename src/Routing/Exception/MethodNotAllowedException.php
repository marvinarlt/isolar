<?php

namespace Isolar\Routing\Exception;

class MethodNotAllowedException extends \Exception
{
    public function __construct()
    {
        http_response_code(405);
        exit;
    }
}