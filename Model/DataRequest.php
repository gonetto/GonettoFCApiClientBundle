<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class DataRequest
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class DataRequest implements RequestInterface
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
    protected $action = 'data';

    /**
     * @var \DateTime
     *
     * @JMS\Type("DateTime<'Y-m-d\TH:i:s.v\Z', 'Europe/Berlin'>")
     * @JMS\SerializedName("since")
     */
    protected $sinceDate;

    /**
     * @param string $token
     *
     * @return DataRequest
     */
    public function setToken(string $token): DataRequest
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
     * @return \DateTime|null
     */
    public function getSinceDate(): ?\DateTime
    {
        return $this->sinceDate;
    }

    /**
     * @param \DateTime $sinceDate
     *
     * @return DataRequest
     */
    public function setSinceDate(?\DateTime $sinceDate): DataRequest
    {
        $this->sinceDate = $sinceDate;

        return $this;
    }
}
