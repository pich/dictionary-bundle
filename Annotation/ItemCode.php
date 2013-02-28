<?php
namespace Webit\Common\DictionaryBundle\Annotation;

use Doctrine\Common\Annotations\Annotation as DoctrineAnnotation;

/**
 * 
 * @author dbojdo
 * @Annotation
 */
final class ItemCode extends DoctrineAnnotation {
	/** @var string */
	public $dictionaryName;
	/** @var string */
	public $itemProperty;
}
?>
