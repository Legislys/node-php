<?php

declare(strict_types=1);

namespace App;

class Request
{
    private array $get = [];
    private array $post = [];

    public function __construct(array $get, array $post)
    {
        $this->get = $get;
        $this->post = $post;
    }

    public function getParams(string $method, $defualt = null)
    {
        return $this->$method ?? $defualt;
    }

    public function hasPost(): bool
    {
        return !empty($this->post);
    }
}
