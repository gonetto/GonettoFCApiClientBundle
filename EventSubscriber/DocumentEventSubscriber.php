<?php

namespace Gonetto\FCApiClientBundle\EventSubscriber;

use Gonetto\FCApiClientBundle\Model\Document;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Symfony\Component\Yaml\Yaml;

/**
 * Class DocumentEventSubscriber
 *
 * @package Gonetto\FCApiClientBundle\EventSubscriber
 */
class DocumentEventSubscriber implements EventSubscriberInterface
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
            'class' => Document::class,
          ],
        ];
    }

    /**
     * @param \JMS\Serializer\EventDispatcher\ObjectEvent $event
     */
    public function onPostDeserialize(ObjectEvent $event)
    {
        // Current contract
        /** @var Document $document */
        $document = $event->getObject();

        $documentTypes = Yaml::parseFile(__DIR__.'/document_type.yml');

        // Replace text
        $key = $document->getType();

        if (array_key_exists($key, $documentTypes)) {
            $document->setType($documentTypes[$key]);
        }
    }
}
