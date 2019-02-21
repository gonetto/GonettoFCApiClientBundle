<?php

namespace Gonetto\FCApiClientBundle\Service;

use Gonetto\FCApiClientBundle\Model\FileRequest;

/**
 * Class FileRequestFactory
 *
 * @package AppBundle\Service
 */
class FileRequestFactory
{

    /** @var string */
    static $token;

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
     */
    public function createResponse(): FileRequest
    {
        return (new FileRequest())->setToken(self::$token);
    }
}
