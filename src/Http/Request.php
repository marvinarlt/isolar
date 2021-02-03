<?php

namespace Isolar\Http;

class Request
{
    /**
     * @var mixed
     */
    protected $server;

    /**
     * @var mixed
     */
    protected $get;

    /**
     * @var mixed
     */
    protected $post;

    /**
     * @var mixed
     */
    protected $cookie;

    /**
     * @var mixed
     */
    protected $files;

    /**
     * @var array
     */
    protected $currentRoute;

    /**
     * @param mixed $server
     * @param mixed $get
     * @param mixed $post
     * @param mixed $cookie
     * @param mixed $files
     */
    public function __construct(mixed $server, mixed $get, mixed $post, mixed $cookie, mixed $files)
    {
        $this->server = $server;
        $this->get = $get;
        $this->post = $post;
        $this->cookie = $cookie;
        $this->files = $files;
    }

    /**
     * @return Request
     */
    public static function createFromGlobals(): Request
    {
        return new static(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
    }

    /**
     * @param array $route
     * 
     * @return void
     */
    public function setCurrentRoute(array $route): void
    {
        $this->currentRoute = $route;
    }

    /**
     * @return array
     */
    public function getCurrentRoute(): array
    {
        return $this->currentRoute;
    }

    /**
     * Returns the parameter value if set.
     * 
     * @param string $name
     * 
     * @return string
     */
    public function getParameter(string $name = null): mixed
    {
        if (! isset($this->currentRoute['parameters'])) {
            return '';
        }

        if (is_null($name)) {
            return $this->currentRoute['parameters'];
        }

        if (! isset($this->currentRoute['parameters'][$name])) {
            return '';
        }

        return $this->currentRoute['parameters'][$name];
    }
    
    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->server['HTTP_HOST'];
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return isset($this->server['REDIRECT_URL']) ? $this->server['REDIRECT_URL'] : '/';
    }

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->isSecure() ? 'https' : 'http';
    }

    /**
     * @return string
     */
    public function getRoot(): string
    {
        return $this->getProtocol() . '://' . $this->getHost();
    }

    /**
     * @return string
     */
    public function getDocumentRoot(): string
    {
        return $this->server['DOCUMENT_ROOT'];
    }

    /**
     * @return bool
     */
    public function isSecure(): bool
    {
        return $this->server['HTTPS'] ? true : false;
    }
}