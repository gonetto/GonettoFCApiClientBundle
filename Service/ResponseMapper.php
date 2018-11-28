<?php

namespace Gonetto\FCApiClientBundle\Service;

use Gonetto\FCApiClientBundle\Model\FinanceConsult;
use JMS\Serializer\SerializerBuilder;

class ResponseMapper
{

    /** @var \JMS\Serializer\Serializer */
    protected $serializer;

    public function __construct()
    {
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     * Deserialize the response
     *
     * @param string $jsonResponse
     *
     * @return mixed
     * @throws \Exception
     */
    public function map(string $jsonResponse)
    {
        /** @var FinanceConsult $response */
        $response = $this->serializer->deserialize($jsonResponse, FinanceConsult::class, 'json');

        return $response->getCustomers();
    }
}
