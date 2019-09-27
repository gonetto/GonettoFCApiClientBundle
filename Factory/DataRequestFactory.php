<?php

namespace Gonetto\FCApiClientBundle\Factory;

use Exception;
use Gonetto\FCApiClientBundle\Model\DataRequest;

/**
 * Class DataRequestFactory
 *
 * @package AppBundle\Service
 */
class DataRequestFactory implements RequestFactoryInterface
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
     * @return \Gonetto\FCApiClientBundle\Model\DataRequest
     * @throws \Exception
     */
    public function createRequest(): DataRequest
    {
        if (empty(self::$token)) {
            throw new Exception('API token can not be empty');
        }

        return (new DataRequest())->setToken(self::$token);
    }
}
