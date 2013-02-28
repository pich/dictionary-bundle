<?php
namespace Webit\Common\DictionaryBundle\Document;
use Webit\Common\DictionaryBundle\Model\DictionaryInterface;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCRODM;
use Webit\Bundle\PHPCRToolsBundle\Document\Generic;

/**
 * Webit\Common\DictionaryBundle\Document\Dictionary\Dictionary
 * @author dbojdo
 */
class Dictionary extends Generic implements DictionaryInterface {
	/**
	 * @var string
	 */
	protected $measure;

	/**
	 * @var string
	 */
	protected $code;

	/**
	 * @var string
	 */
	protected $symbol;

	/**
	 * 
	 * @var string
	 */
	protected $label;

	/**
	 * @param string $measure
	 */
	public function __construct($measure) {
		$this->measure = $measure;
	}

	/**
	 * @return string
	 */
	public function getMeasure() {
		return $this->measure;
	}

	/**
	 * @return string
	 */
	public function getSymbol() {
		return $this->symbol;
	}

	/**
	 * 
	 * @param string $symbol
	 */
	public function setSymbol($symbol) {
		$this->symbol = $symbol;
	}

	/**
	 * @return string
	 */
	public function getLabel() {
		return $this->label;
	}

	/**
	 * 
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
	
	public function getFullSymbol() {
		return $this->getMeasure() . ':' . $this->getCode();
	}
	
	public function __toString() {
		return $this->getMeasure() . ':' . $this->getCode();
	}
	
	public function __sleep() {
		return array('id', 'measure', 'label', 'symbol','code');
	}
}
?>
