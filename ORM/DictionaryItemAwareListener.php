<?php
namespace Webit\Common\DictionaryBundle\ORM;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemAwareInterface;
use Webit\Common\DictionaryBundle\Model\DictionaryItem\DictionaryItemFetcher;

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
     * @return DictionaryItemFetcher
     */
    private function dictionaryItemFetcher()
    {
        return $this->container->get('webit_common_dictionary.dictionary_item_fetcher');
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof DictionaryItemAwareInterface) {
            $this->dictionaryItemFetcher()->fetchItem($entity);
        }
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof DictionaryItemAwareInterface) {
            $this->dictionaryItemFetcher()->fetchItemCode($entity);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof DictionaryItemAwareInterface) {
            $this->dictionaryItemFetcher()->fetchItemCode($entity);
        }
    }
}
