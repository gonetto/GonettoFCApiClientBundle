<?php

namespace Gonetto\FCApiClientBundle\Service;

use Gonetto\FCApiClientBundle\Model\FinanceConsultCustomer;
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
     * @param string $response
     *
     * @return mixed
     * @throws \Exception
     */
    public function map(string $response)
    {
        // Decode response
        $customers = json_decode($response);

        $deserializedCustomers = [];
        foreach ($customers->kunden as $customer) {
            $deserializedCustomers[] = $this->newMap(json_encode($customer));
        }

        return $deserializedCustomers;
    }

    protected function newMap(string $customerJson)
    {
        $customers = $this->serializer->deserialize($customerJson, FinanceConsultCustomer::class, 'json');

        echo PHP_EOL.'$customerJson:'.PHP_EOL;
        var_dump($customerJson);

        echo PHP_EOL.'$customer:'.PHP_EOL;
        var_dump($customers);

        return $customers;
    }
}
