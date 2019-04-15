<?php

namespace Gonetto\FCApiClientBundle\EventSubscriber;

use Gonetto\FCApiClientBundle\Model\Contract;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ContractEventSubscriber
 *
 * @package Gonetto\FCApiClientBundle\EventSubscriber
 */
class ContractEventSubscriber implements EventSubscriberInterface
{

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
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
    public function onPostDeserialize(ObjectEvent $event): void
    {
        // Current contract
        /** @var Contract $contract */
        $contract = $event->getObject();

        $paymentIntervals = Yaml::parseFile(__DIR__.'/payment_intervals.yml');

        // Replace text
        $key = $contract->getPaymentInterval();
        if (array_key_exists($key, $paymentIntervals)) {
            $contract->setPaymentInterval($paymentIntervals[$key]);
        } else {
            $contract->setPaymentInterval(0);
        }
    }
}
