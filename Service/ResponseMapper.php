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
    // TODO:GN:MS: inn factory umbauen

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
     * @return array
     * @throws \Exception
     *
     * @deprecated
     * @see \Gonetto\FCApiClientBundle\Service\ResponseMapper::map()
     */
    public function mapCustomers(string $jsonResponse): array
    {
        /** @var DataResponse $response */
        $response = $this->serializer->deserialize($jsonResponse, DataResponse::class, 'json');

        return $response->getCustomers();
    }

    /**
     * Deserialize the response
     *
     * @param string $jsonResponse
     *
     * @return \Gonetto\FCApiClientBundle\Model\DataResponse
     */
    public function map(string $jsonResponse): DataResponse
    {
        return $this->serializer->deserialize($jsonResponse, DataResponse::class, 'json');
    }
}
