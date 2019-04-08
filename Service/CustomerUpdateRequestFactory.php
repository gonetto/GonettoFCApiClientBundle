<?php

namespace Gonetto\FCApiClientBundle\Service;

use Gonetto\FCApiClientBundle\Model\CustomerUpdateRequest;

/**
 * Class DataRequestFactory
 *
 * @package AppBundle\Service
 */
class CustomerUpdateRequestFactory
{

    /** @var string */
    static $token;

    /**
     * DataRequestFactory constructor.
     *
     * @param string $token
     */
    public function __construct(string $token = '')
    {
        self::$token = $token;
    }

    /**
     * @return \Gonetto\FCApiClientBundle\Model\CustomerUpdateRequest
     */
    public function createResponse(): CustomerUpdateRequest
    {
        return (new CustomerUpdateRequest())->setToken(self::$token);
    }
}
