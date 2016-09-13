<?php

namespace parser;

interface Renderable {
	public function __toString();
	public function render(\parser\OutputFormat $oOutputFormat);
	public function getLineNo();
}