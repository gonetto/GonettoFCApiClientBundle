<?php

namespace Gonetto\FCApiClientBundle\Factory;

use Gonetto\FCApiClientBundle\EventSubscriber\ContractEventSubscriber;
use Gonetto\FCApiClientBundle\EventSubscriber\DocumentEventSubscriber;
use JMS\Serializer\EventDispatcher\EventDispatcher;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class JmsSerializerFactory
{

    /** @var \JMS\Serializer\Serializer */
    public static $serializer;

    /**
     * JmsSerializerFactory constructor.
     */
    public function __construct()
    {
        // Register event subscriber
        self::$serializer = SerializerBuilder::create()
            ->configureListeners(
                static function (EventDispatcher $dispatcher) {
                    $dispatcher->addSubscriber(new ContractEventSubscriber());
                    $dispatcher->addSubscriber(new DocumentEventSubscriber());
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
