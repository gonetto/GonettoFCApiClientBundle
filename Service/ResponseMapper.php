<?php

namespace Gonetto\FCApiClientBundle\Service;

use Gonetto\FCApiClientBundle\EventSubscriber\ContractEventSubscriber;
use Gonetto\FCApiClientBundle\Model\FinanceConsultResponse;
use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\SerializerBuilder;

class ResponseMapper
{

    /** @var \JMS\Serializer\Serializer */
    protected $serializer;

    public function __construct()
    {
        // Register event subscriber
        $builder = SerializerBuilder::create();
        $builder->configureListeners(
          function (EventDispatcher $dispatcher) {
              $dispatcher->addSubscriber(new ContractEventSubscriber());
          }
        );

        // Get serializer
        $this->serializer = $builder->build();
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
        /** @var FinanceConsultResponse $response */
        $response = $this->serializer->deserialize($jsonResponse, FinanceConsultResponse::class, 'json');

        return $response->getCustomers();
    }
}
