<?php

namespace CSSInliner;

use CSSInliner\Exceptions;
use parser;
use cssSelector\CssSelector;

/**
 * Class CSSInliner
 * @author Northys
 * @package Northys\CSSInliner
 */
class CSSInliner
{
	/**
	 * @var parser\CSSList\Document
	 */
	private $css;

	/**
	 * @var \DOMDocument
	 */
	private $dom;

	/**
	 * @var \DOMXPath
	 */
	private $finder;

    /**
     * Provides you an option to add as many CSS files as you want
     * @param string $filename represents css file path
     * @throws \Exception
     */
    public function addCSS($filename)
	{
		if (($css = @file_get_contents($filename)) === FALSE) {
			throw new Exceptions\InvalidCssFilePathException('Invalid css file path provided.');
		}
		// merge all CSS content into $this-css variable
		$this->css .= $css;
	}


    /**
     * Gets styles from <style> html tag - if there are any it will be merged with another styles added by addCss()
     * @return parser\CSSList\Document
     * @throws \Exception
     */
    private function getCSS() {
		// get styles inside <style> tags in provided HTML
		foreach ($this->dom->getElementsByTagName('style') as $style) {
			$this->css .= $style->textContent;
		}
		$parser = new parser\Parser($this->css);

		$css = $parser->parse();
		if (!$css) {
			throw new Exceptions\NoCssRulesException('There are no CSS rules provided.');
		}
		return $css;
	}


    /**
     * Prepares everything and inserts inline styles into html
     * @param string $html represents html document
     * @return string
     */
    public function render($html,$debug = false)
	{
		$this->dom = new \DOMDocument;
		$this->dom->loadHTML($html);
		$this->finder = new \DOMXPath($this->dom);
		$this->css = $this->getCSS();
		foreach ($this->css->getAllRuleSets() as $ruleSet) {
			$selector = $ruleSet->getSelector();
			$csss = new CssSelector();
			if($debug) var_dump($selector);
			foreach ($this->finder->evaluate($csss->toXPath($selector[0])) as $node) {
				if ($node->getAttribute('style')) {
					$node->setAttribute('style', $node->getAttribute('style') . implode(' ', $ruleSet->getRules()));
				} else {
					$node->setAttribute('style', implode(' ', $ruleSet->getRules()));
				}
			}
		}

		return $this->dom->saveHTML();
	}

}
