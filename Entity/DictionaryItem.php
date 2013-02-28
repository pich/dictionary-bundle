<?php
namespace Webit\Common\DictionaryBundle\Entity;

use Webit\Common\DictionaryBundle\Model\DictionaryItemInterface;

/**
 * Webit\Accounting\CommonBundle\Entity\DictionaryItem
 * @author dbojdo
 */
class DictionaryItem implements DictionaryItemInterface {
	/**
	 * @var int
	 */
	protected $id;
	
	/**
	 * @var string
	 */
	protected $code;

	/**
	 * @var string
	 */
	protected $label

	public function getId() {
		return $this->id;
	}
	
	/**
	 * @return string
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * @param string $label
	 */
	public function setLabel($label) {
		$this->label = $label;
	}
	
	/**
	 * @return string
	 */
	public function getCode() {
		return $this->code;
	}
	
	/**
	 * @param string $code
	 */
	public function setCode($code) {
		$this->code = $code;
	}
}
?>
