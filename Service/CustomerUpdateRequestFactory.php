<?php

namespace Gonetto\FCApiClientBundle\Service;

use Exception;
use Gonetto\FCApiClientBundle\Model\CustomerUpdateRequest;

/**
 * Class DataRequestFactory
 *
 * @package AppBundle\Service
 */
class CustomerUpdateRequestFactory implements RequestFactoryInterface
{

    /** @var string */
    public static $token;

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
     * @throws \Exception
     */
    public function createRequest(): CustomerUpdateRequest
    {
        if (empty(self::$token)) {
            throw new Exception('API token can not not be empty');
        }

        return (new CustomerUpdateRequest())->setToken(self::$token);
    }
}
