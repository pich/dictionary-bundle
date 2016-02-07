<?php
namespace Webit\Common\DictionaryBundle\PHPCR;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemAwareInterface;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemFetcherInterface;

class DictionaryItemAwareListener implements ContainerAwareInterface, EventSubscriber
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
            'prePersist',
            'preUpdate',
        );
    }

    /**
     *
     * @return DictionaryItemFetcherInterface
     */
    private function dictionaryItemFetcher()
    {
        return $this->container->get('webit_common_dictionary.dictionary_item_fetcher');
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $doc = $args->getObject();
        if ($doc instanceof DictionaryItemAwareInterface) {
            $this->dictionaryItemFetcher()->fetchItem($doc);
        }
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $doc = $args->getObject();
        if ($doc instanceof DictionaryItemAwareInterface) {
            $this->dictionaryItemFetcher()->fetchItemCode($doc);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $doc = $args->getObject();
        if ($doc instanceof DictionaryItemAwareInterface) {
            $this->dictionaryItemFetcher()->fetchItemCode($doc);
        }
    }
}
