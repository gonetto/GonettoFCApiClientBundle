<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class FileRequest
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class FileRequest implements RequestInterface
{

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("token")
     */
    protected $token;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("action")
     */
    protected $action = 'doc';

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("oid")
     */
    protected $documentId;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("vertragId")
     */
    protected $contractId;

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return FileRequest
     */
    public function setToken(string $token): FileRequest
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return string
     */
    public function getDocumentId(): string
    {
        return $this->documentId;
    }

    /**
     * @param string $documentId
     *
     * @return FileRequest
     */
    public function setDocumentId(string $documentId): FileRequest
    {
        $this->documentId = $documentId;

        return $this;
    }

    /**
     * @return string
     */
    public function getContractId(): string
    {
        return $this->contractId;
    }

    /**
     * @param string $contractId
     *
     * @return FileRequest
     */
    public function setContractId(string $contractId): FileRequest
    {
        $this->contractId = $contractId;

        return $this;
    }
}
