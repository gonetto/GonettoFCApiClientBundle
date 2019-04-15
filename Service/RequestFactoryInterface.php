<?php

namespace Gonetto\FCApiClientBundle\Service;

/**
 * Interface RequestFactoryInterface
 *
 * @package Gonetto\FCApiClientBundle\Service
 */
interface RequestFactoryInterface
{

    /**
     * @return \Gonetto\FCApiClientBundle\Model\RequestInterface
     */
    public function createRequest();
}
