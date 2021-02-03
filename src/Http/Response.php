<?php

namespace Isolar\Http;

class Response
{
    /**
     * Raw text response.
     * 
     * @param string $message
     * @param int $httpCode
     * 
     * @return string
     */
    public function text(string $message, int $httpCode = 200): string
    {
        $this->httpCode($httpCode);

        return $message;
    }

    /**
     * Json encoded string response.
     * 
     * @param mixed $data
     * @param int $httpCode
     * 
     * @return string
     */
    public function json(mixed $data, int $httpCode = 200): string
    {
        $this->httpCode($httpCode);

        return json_encode($data, JSON_PRETTY_PRINT);
    }

    /**
     * Sets the response code.
     * 
     * @param int $httpCode
     * 
     * @return void
     */
    public function httpCode(int $httpCode): void
    {
        http_response_code($httpCode);
    }
}