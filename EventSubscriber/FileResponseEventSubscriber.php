<?php

namespace Gonetto\FCApiClientBundle\EventSubscriber;

use Gonetto\FCApiClientBundle\Model\FileResponse;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Symfony\Component\Yaml\Yaml;

/**
 * Class FileResponseEventSubscriber
 *
 * @package Gonetto\FCApiClientBundle\EventSubscriber
 */
class FileResponseEventSubscriber implements EventSubscriberInterface
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
            'class' => FileResponse::class,
          ],
        ];
    }

    /**
     * @param \JMS\Serializer\EventDispatcher\ObjectEvent $event
     */
    public function onPostDeserialize(ObjectEvent $event)
    {
        // Current contract
        /** @var FileResponse $fileResponse */
        $fileResponse = $event->getObject();

        $paymentIntervals = Yaml::parseFile(__DIR__.'/document_type.yml');

        // Replace text
        $key = $fileResponse->getDocumentType();
        if (array_key_exists($key, $paymentIntervals)) {
            $fileResponse->setDocumentType($paymentIntervals[$key]);
        }
    }
}
