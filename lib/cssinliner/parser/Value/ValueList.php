<?php

namespace parser\Value;

abstract class ValueList extends Value {

	protected $aComponents;
	protected $sSeparator;

	public function __construct($aComponents = array(), $sSeparator = ',', $iLineNo = 0) {
		parent::__construct($iLineNo);
		if (!is_array($aComponents)) {
			$aComponents = array($aComponents);
		}
		$this->aComponents = $aComponents;
		$this->sSeparator = $sSeparator;
	}

	public function addListComponent($mComponent) {
		$this->aComponents[] = $mComponent;
	}

	public function getListComponents() {
		return $this->aComponents;
	}

	public function setListComponents($aComponents) {
		$this->aComponents = $aComponents;
	}

	public function getListSeparator() {
		return $this->sSeparator;
	}

	public function setListSeparator($sSeparator) {
		$this->sSeparator = $sSeparator;
	}

	public function __toString() {
		return $this->render(new \parser\OutputFormat());
	}

	public function render(\parser\OutputFormat $oOutputFormat) {
		return $oOutputFormat->implode($oOutputFormat->spaceBeforeListArgumentSeparator($this->sSeparator) . $this->sSeparator . $oOutputFormat->spaceAfterListArgumentSeparator($this->sSeparator), $this->aComponents);
	}

}
