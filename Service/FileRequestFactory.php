<?php

namespace Gonetto\FCApiClientBundle\Service;

use Exception;
use Gonetto\FCApiClientBundle\Model\FileRequest;

/**
 * Class FileRequestFactory
 *
 * @package AppBundle\Service
 */
class FileRequestFactory implements RequestFactoryInterface
{

    /** @var string */
    public static $token;

    /**
     * FileRequestFactory constructor.
     *
     * @param string $token
     */
    public function __construct(string $token = '')
    {
        self::$token = $token;
    }

    /**
     * @return \Gonetto\FCApiClientBundle\Model\FileRequest
     * @throws \Exception
     */
    public function createRequest(): FileRequest
    {
        if (empty(self::$token)) {
            throw new Exception('API token can not not be empty');
        }

        return (new FileRequest())->setToken(self::$token);
    }
}
