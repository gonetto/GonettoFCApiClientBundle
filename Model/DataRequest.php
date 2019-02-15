<?php

namespace Gonetto\FCApiClientBundle\Model;

use JMS\Serializer\Annotation as JMS;

/**
 * Class DataRequest
 *
 * @package Gonetto\FCApiClientBundle\Model
 */
class DataRequest
{

    /**
     * @var string
     *
     * @JMS\Type("string")
     * @JMS\SerializedName("token")
     */
    protected $token;

    /**
     * @var \DateTime
     *
     * @JMS\Type("DateTime<'Y-m-d\TH:i:s.v\Z', 'Europe/Berlin'>")
     * @JMS\SerializedName("since")
     */
    protected $sinceDate;

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
     * @return DataRequest
     */
    public function setToken(string $token): DataRequest
    {
        $this->token = $token;

        return $this;
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
    public function setSinceDate(\DateTime $sinceDate): DataRequest
    {
        $this->sinceDate = $sinceDate;

        return $this;
    }
}
