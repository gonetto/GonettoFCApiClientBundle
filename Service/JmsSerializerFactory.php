<?php

namespace Gonetto\FCApiClientBundle\Service;

use Gonetto\FCApiClientBundle\EventSubscriber\ContractEventSubscriber;
use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

/**
 * Class JmsSerializerFactory
 *
 * @package Gonetto\FCApiClientBundle\Service
 */
class JmsSerializerFactory
{

    /** @var \JMS\Serializer\Serializer */
    static $serializer;

    /**
     * JmsSerializerFactory constructor.
     */
    public function __construct()
    {
        // Register event subscriber
        self::$serializer = SerializerBuilder::create()
            ->configureListeners(
                function (EventDispatcher $dispatcher) {
                    $dispatcher->addSubscriber(new ContractEventSubscriber());
                }
            )
            ->build();
    }

    /**
     * @return \JMS\Serializer\Serializer
     */
    public function createSerializer(): Serializer
    {
        return self::$serializer;
    }
}
