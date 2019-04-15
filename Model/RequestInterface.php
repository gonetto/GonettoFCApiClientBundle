<?php

namespace Gonetto\FCApiClientBundle\Model;

/**
 * Interface RequestInterface
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
interface RequestInterface
{

    /**
     * @return string
     */
    public function getToken(): string;

    /**
     * @param string $token
     */
    public function setToken(string $token);

    /**
     * @return string
     */
    public function getAction(): string;
}
