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
     * @param string $token
     *
     * @return \Gonetto\FCApiClientBundle\Model\RequestInterface
     */
    public function setToken(string $token);

    /**
     * @return string
     */
    public function getAction(): string;
}