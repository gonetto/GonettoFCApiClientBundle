<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Customer
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class CustomerUpdateRequest extends Customer implements RequestInterface
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
    protected $action = 'setKunde';

    /**
     * @param string $token
     *
     * @return CustomerUpdateRequest
     */
    public function setToken(string $token): CustomerUpdateRequest
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
}
