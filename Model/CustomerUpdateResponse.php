<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class DataResponse
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class CustomerUpdateResponse
{

    /**
     * @var boolean
     *
     * @JMS\Type("boolean")
     * @JMS\SerializedName("result")
     */
    protected $success;

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("error")
     */
    protected $errorMessage;

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param bool $success
     *
     * @return CustomerUpdateResponse
     */
    public function setSuccess(bool $success): self
    {
        $this->success = $success;

        return $this;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     *
     * @return CustomerUpdateResponse
     */
    public function setErrorMessage(string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }
}
