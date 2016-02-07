<?php
namespace Webit\Common\DictionaryBundle\Model\DictionaryItem;

use JMS\Serializer\EventDispatcher\Event;

class DictionaryItemAwareSerializationListener
{
    /**
     * @var DictionaryItemFetcherInterface
     */
    private $dictionaryFetcher;

    /**
     * DictionaryItemAwareSerializationListener constructor.
     * @param DictionaryItemFetcherInterface $dictionaryFetcher
     */
    public function __construct(DictionaryItemFetcherInterface $dictionaryFetcher)
    {
        $this->dictionaryFetcher = $dictionaryFetcher;
    }

    public function postDeserialize(Event $event)
    {
        $doc = $event->getObject();
        if ($doc instanceof DictionaryItemAwareInterface) {
            $this->dictionaryFetcher->fetchItem($doc);
        }
    }
}
