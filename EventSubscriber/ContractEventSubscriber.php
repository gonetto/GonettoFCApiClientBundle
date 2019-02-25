<?php

namespace Gonetto\FCApiClientBundle\EventSubscriber;

use Gonetto\FCApiClientBundle\Model\Contract;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Symfony\Component\Yaml\Yaml;

/**
 * Class EventSubscriber
 *
 * @package Gonetto\FCApiClientBundle\EventSubscriber
 */
class ContractEventSubscriber implements EventSubscriberInterface
{

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
          [
            'event' => 'serializer.post_deserialize',
            'method' => 'onPostDeserialize',
            'class' => Contract::class,
          ],
        ];
    }

    /**
     * @param \JMS\Serializer\EventDispatcher\ObjectEvent $event
     */
    public function onPostDeserialize(ObjectEvent $event)
    {
        // Current contract
        /** @var Contract $contract */
        $contract = $event->getObject();

        $paymentIntervals = Yaml::parseFile('EventSubscriber/payment_intervals.yml');

        // Replace text
        $key = $contract->getPaymentInterval();
        if (array_key_exists($key, $paymentIntervals)) {
            $contract->setPaymentInterval($paymentIntervals[$key]);
        }
    }
}
