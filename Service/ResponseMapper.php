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
     * @param string $response
     *
     * @return mixed
     * @throws \Exception
     */
    public function map(string $response)
    {
        /** @var FinanceConsult $customers */
        $customers = $this->serializer->deserialize($response, FinanceConsult::class, 'json');

        return $customers->getCustomers();
    }
}
