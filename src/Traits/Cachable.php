<?php

namespace OneGiba\DataLayer\Traits;

trait Cachable
{
    /**
     * Magic call method to caching results of methods from repositories.
     *
     * @param string $method
     * @param array  $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters): mixed
    {
        return null;
    }
}