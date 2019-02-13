<?php

namespace Gonetto\FCApiClientBundle\Service;

use Gonetto\FCApiClientBundle\EventSubscriber\ContractEventSubscriber;
use Gonetto\FCApiClientBundle\Model\DataResponse;
use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\SerializerBuilder;

/**
 * Class ResponseMapper
 *
 * @package Gonetto\FCApiClientBundle\Service
 */
class ResponseMapper
{

    /** @var \JMS\Serializer\Serializer */
    protected $serializer;

    /**
     * ResponseMapper constructor.
     */
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
        /** @var DataResponse $response */
        $response = $this->serializer->deserialize($jsonResponse, DataResponse::class, 'json');

        return $response->getCustomers();
    }
}
