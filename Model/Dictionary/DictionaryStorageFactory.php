<?php
namespace Webit\Common\DictionaryBundle\Model\Dictionary;

use Doctrine\Common\Annotations\Reader;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DictionaryStorageFactory implements ContainerAwareInterface, DictionaryStorageFactoryInterface
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

    /**
     * @param array $config
     * @return DictionaryStorageInterface
     */
    public function createStorage(array $config)
    {
        $arArguments = array();
        switch ($config['storageType']) {
            case 'orm':
                $class = $this->container->getParameter('webit_common_dictionary.orm.storage.class');
                $rootProperty = $this->getRootProperty($config['itemClass']);
                $codeProperty = $this->getCodeProperty($config['itemClass']);

                $arArguments = array(
                    $this->container->get('webit_common_dictionary.cache'),
                    $this->container->get('webit_common_dictionary.orm.entity_manager'),
                    $config['name'],
                    $config['itemClass'],
                    $codeProperty,
                    $rootProperty,
                    $config['root']
                );
                break;
            case 'phpcr':
                $class = $this->container->getParameter('webit_common_dictionary.phpcr.storage.class');
                $codeProperty = $this->getCodeProperty($config['itemClass']);
                $arArguments = array(
                    $this->container->get('webit_common_dictionary.cache'),
                    $this->container->get('webit_common_dictionary.phpcr.document_manager'),
                    $config['name'],
                    $config['itemClass'],
                    $config['root'],
                    $codeProperty
                );
                break;
        }

        $refClass = new \ReflectionClass($class);
        $storage = $refClass->newInstanceArgs($arArguments);

        return $storage;
    }

    /**
     *
     * @return Reader
     */
    private function annotationReader()
    {
        $reader = $this->container->get('annotation_reader');

        return $reader;
    }

    private function getRootProperty($itemClass)
    {
        $annotationName = 'Webit\Common\DictionaryBundle\Annotation\ItemRoot';
        $refClass = new \ReflectionClass($itemClass);
        $reader = $this->annotationReader();

        foreach ($refClass->getProperties() as $name => $property) {
            $itemCodeAnnotation = $reader->getPropertyAnnotation($property, $annotationName);
            if ($itemCodeAnnotation) {
                return $property->getName();
            }
        }

        return null;
    }

    private function getCodeProperty($itemClass)
    {
        $annotationName = 'Webit\Common\DictionaryBundle\Annotation\ItemCode';
        $refClass = new \ReflectionClass($itemClass);
        $reader = $this->annotationReader();

        foreach ($refClass->getProperties() as $name => $property) {
            $itemCodeAnnotation = $reader->getPropertyAnnotation($property, $annotationName);
            if ($itemCodeAnnotation) {
                return $property->getName();
            }
        }

        if ($refClass->hasProperty('code')) {
            return 'code';
        }

        if ($refClass->hasProperty('id')) {
            return 'id';
        }

        return null;
    }
}
