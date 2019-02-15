<?php

namespace Gonetto\FCApiClientBundle\EventSubscriber;

use Gonetto\FCApiClientBundle\Model\Contract;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;

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

    // TODO:GN:MS: wie bei zahlweise mapper auch art mapper bauen, aber clsse mit values? und generiert aus csv/yml?!

    /**
     * @param \JMS\Serializer\EventDispatcher\ObjectEvent $event
     */
    public function onPostDeserialize(ObjectEvent $event)
    {
        // Current contract
        /** @var Contract $contract */
        $contract = $event->getObject();

        // Replace text
        switch ($contract->getPaymentInterval()) {
            case 'monatlich':
                $contract->setPaymentInterval(12);
                break;
            case 'vierteljahrlich':
            case 'vierteljährlich':
            case 'vierteljaehrlich':
                $contract->setPaymentInterval(4);
                break;
            case 'halbjahrlich':
            case 'halbjährlich':
            case 'halbjaehrlich':
                $contract->setPaymentInterval(2);
                break;
            case 'jahrlich':
            case 'jährlich':
            case 'jaehrlich':
                $contract->setPaymentInterval(1);
                break;
            default:
                $contract->setPaymentInterval(0);
        }
    }
}
