<?php

namespace Short\Attribute;

use Attribute;

#[Attribute] class Route
{

    public function __construct(
        private string $path,
        private string|array $method = 'GET')
    {
    }

    /**
     * @return array|string
     */
    public function getMethod(): array|string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}
