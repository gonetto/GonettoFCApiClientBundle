<?php

namespace Gonetto\FCApiClientBundle\Service;

use Gonetto\FCApiClientBundle\Model\DataRequest;

/**
 * Class DataRequestFactory
 *
 * @package AppBundle\Service
 */
class DataRequestFactory
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
     * @return \Gonetto\FCApiClientBundle\Model\DataRequest
     * @throws \Exception
     */
    public function createResponse(): DataRequest
    {
        if (empty(self::$token)) {
            throw new \Exception('API token can not not be empty');
        }

        return (new DataRequest())->setToken(self::$token);
    }
}
