<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of magix cjQuery.
# The above copyright notice and this permission notice shall be included in
# all copies or substantial portions of the Software.
# Magix cjQuery is a library written in PHP 5.
# It can work with a layer of abstraction, to validate data, handle jQuery code in PHP.
# Copyright (C)Magix cjQuery 2009 Gerits Aurelien
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as
# published by the Free Software Foundation, either version 3 of the
# License, or (at your option) any later version.
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
/**
 * 
 * Magix Sitemap
 * 
 * @author Gérits Aurélien
 * @access public
 * @copyright clashdesign
 * @version 0.1
 * @package Create Sitemap XML and sitemap.xml.gz
 *
 */
/**
 * Abstract Class for magix_Sitemap
 * @author Aurelien
 *
 */
abstract class siteMapMain{
	/**
	 * url valid sitemap standard
	 * @var NS string
	 */
	protected $NS = 'http://www.sitemaps.org/schemas/sitemap/0.9';
	/**
	 * URI schema Google sitemap image
	 * @var string
	 */
	protected $googleimages_xmlns = 'http://www.google.com/schemas/sitemap-image/1.1';
	/**
	 * level compressor for GZ
	 * @var (int)GZCompressionLevel
	 */
	protected $GZCompressionLevel = null;
	/**
	 * tabs for changeFreq
	 * @var array() changeFreqControl
	 * @access private
	 */
	private $changeFreqControl = array(
		'always','hourly','daily','weekly','monthly','yearly','never'
	);
	function __construct() {}
	protected function validElement($loc=null,$lastmod=null,$changefreq=null,$priority=null){
		/*if(empty($loc)) {
			throw new Exception('Loc is empty');
		}*/
		if(magixcjquery_filter_isVar::isURL($loc) == false) {
			throw new Exception('Loc is invalid format');
		}
		if($lastmod && !magixcjquery_xml_xml::xmlInstance()->isW3CDate($lastmod)) {
			throw new Exception('Invalid format for lastmod');
		}
		if($changefreq && !in_array($changefreq, $this->changeFreqControl)) {
			throw new Exception('Invalid format for changefreq');
		}
		if($priority && (!is_numeric($priority) || $priority<0 || $priority>1)) {
			throw new Exception('Invalid format for priority 0.0 > 1.0');
		}
		elseif($priority) {
			$priority = sprintf('%0.1f',$priority);
		}
		return true;
	}
	/**
	 * Level for compressor GZIP 0 - 10
	 *
	 * @param int $level level compressor
	 */
	public function setGZCompressionLevel($level) {
		$this->GZCompressionLevel = (int)$level;
	}
	/**
	 * protected abstract function for create file XML and create GZ
	 * @param $file
	 * @param $data
	 * @return void
	 */
	protected function makeFile($file, $data) {
		if((int)$this->GZCompressionLevel !== 0) {
			if(!extension_loaded('zlib')) {
				throw new Exception('Unable to find zlib extension');
			}
			if(!$fp = fopen($data, "r")) {
				throw new Exception('Unable to open sitemap file : '.$file);
			}
			$filesize = filesize($data);
			if($filesize === false){
				throw new Exception("filesize error");
			}
			//echo "Filesize: $filesize";
			
			$datafile = fread($fp, $filesize);
			fclose($fp);
			$mode = 'w' . (int)$this->GZCompressionLevel;
			if(!$zp = gzopen($file, $mode)) {
				throw new Exception('Unable to create/update GZIP sitemap file : '.$file);
			}
			gzwrite($zp, $datafile);
			gzclose($zp);
		}
		return true;
	}
	/**
	 * 
	 * @param $data
	 * @param $level
	 * @return void
	 */
	protected function compress($data, $level=0) {

		if(!(int)$level) {
			return $data;
		}
		return gzcompress($data, (int)$level);
	}
	/**
	 * 
	 * Init curl get
	 * @param string $url
	 * @param string $file
	 */
	private function curl_ping($url,$file){
		try{
	        // PING DU SITEMAP A GOOGLE
	        $ch = curl_init();
	        curl_setopt($ch, CURLOPT_URL, 'http://www.google.com/webmasters/tools/ping?sitemap=http%3A%2F%2F'.$url.'%2F'.$file);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_REFERER, magixcjquery_html_helpersHtml::getUrl());
	        curl_setopt ($ch, CURLOPT_NOBODY, 1);
	        $body = curl_exec($ch);
	        curl_close($ch);   
		}catch(Exception $e){
        	trigger_error($e->getMessage(), E_USER_ERROR);
		}
	}
	/**
	 * 
	 * @param $url
	 * @param $file
	 * @return request ping Google webmaster Tools for sitemap update
	 */
	protected function googlePing($url,$file){
		/**
		 * Find out whether an extension "pecl_http" is loaded + and Class exists
		 */
		if (extension_loaded('pecl_http')) {
			if (class_exists('HttpResponse')){
				HttpResponse::getRequestBody('http://www.google.com/webmasters/tools/ping?sitemap=http%3A%2F%2F'.$url.'%2F'.$file);
			}
		}elseif (extension_loaded('curl')) {
            $this->curl_ping($url,$file);
        }else{
			file_get_contents('http://www.google.com/webmasters/tools/ping?sitemap=http%3A%2F%2F'.$url.'%2F'.$file);
		}
	}
}
/**
 * magix_Sitemap extends siteMapMain
 * @author Aurelien
 *
 */
class magixcjquery_xml_sitemap extends siteMapMain{
	/**
	 * 
	 * @var instance XML WRITER
	 */
	protected $writer;
	/**
	 * 
	 * @var array() siteMapURL
	 * @access private
	 */
	private $siteMapURL = array();
	/**
	 * Construct
	 * @return void
	 */
	function __construct(){
		$this->writer = magixcjquery_xml_xml::xmlInstance()->xmlWriter;
	}
	/**
	 * Create XML File implement createFile
	 * @param $file (string)
	 * @return void
	 */
	public function createXML($fpath,$file){
		magixcjquery_xml_xml::xmlInstance()->createFile($fpath,$file);
	}
	/**
	 * Open File and Create new xmlwriter using source uri for output (implement openUrilXml)
	 * @param $file (string)
	 * @return void
	 */
	public function openFile($fpath,$file){
		magixcjquery_xml_xml::xmlInstance()->openUriXml($fpath,$file);
	}
	/**
	 * Toggle indentation on/off (implement indent)
	 * @param $indent = true/false
	 * @return void
	 */
	public function indentXML($indent=true){
		magixcjquery_xml_xml::xmlInstance()->indent($indent);
	}
	/**
	 * Start write head in XML file for Sitemap INDEX
	 * @param $encode
	 * @return void
	 */
	public function headSitemapIndex($encode="UTF-8"){
		$this->writer->startDocument('1.0', $encode);
		$this->writer->writeComment('Generated by magix cjQuery Framework');
		$this->writer->startElement ('sitemapindex'); // [1] First Node
		$this->writer->writeAttribute('xmlns' , $this->NS);
	}
	/**
	 * Start write head in XML file for Sitemap
	 * @param $encode (string)
	 */
	public function headSitemap($encode="UTF-8"){
		$this->writer->startDocument('1.0', $encode);
		$this->writer->writeComment('Generated by magix cjQuery Framework');
		$this->writer->startElement ('urlset'); // [1] First Node
		$this->writer->writeAttribute('xmlns' , $this->NS);
	}
	/**
	 * Start write head sitemap image in XML file
	 * @param string $encode
	 */
	public function headSitemapImage($encode="UTF-8"){
		$this->writer->startDocument('1.0', $encode);
		$this->writer->writeComment('Generated by magix cjQuery Framework');
		$this->writer->startElement ('urlset'); // [1] First Node
		$this->writer->writeAttribute('xmlns' , $this->NS);
		$this->writer->writeAttribute('xmlns:image' , $this->googleimages_xmlns);
	}
	/**
	 * Start write head in XML file
	 * @param $encode
	 * @return void
	 */
	/*function startWrite($encode="UTF-8"){
		$this->writer->startDocument('1.0', $encode);
		$this->writer->writeComment('Generated by magix cjQuery Framework');
		$this->writer->startElement ('urlset'); // [1] First Node
		$this->writer->writeAttribute('xmlns:dc' , $this->NS);
	}*/
/**
	 * create childnode sitemap from parent sitemapindex
	 * @param $encode
	 * @return void
	 */
	public function writeMakeNodeIndex($loc,$lastmod){
		if($this->validElement($loc,$lastmod) == true){
			$this->writer->startElement('sitemap');// [2] Second Node
			$this->writer->writeElement('loc',magixcjquery_filter_isVar::isURL(magixcjquery_filter_var::escapeHTML($loc)));
			$this->writer->writeElement('lastmod',magixcjquery_xml_xml::xmlInstance()->dateIsW3c($lastmod));
			$this->writer->endElement();
		}
	}
	/**
	 * create childnode url from parent urlset
	 * @param $encode
	 * @return void
	 */
	public function writeMakeNode($loc,$lastmod,$changefreq,$priority){
		if($this->validElement($loc,$lastmod,$changefreq,$priority) == true){
			$this->writer->startElement('url');// [2] Second Node
			$this->writer->writeElement('loc',magixcjquery_filter_isVar::isURL(magixcjquery_filter_var::escapeHTML($loc)));
			$this->writer->writeElement('lastmod',magixcjquery_xml_xml::xmlInstance()->dateIsW3c($lastmod));
			$this->writer->writeElement('changefreq',$changefreq);
			$this->writer->writeElement('priority',$priority);
			$this->writer->endElement();
		}
	}
	/**
	 * Create childnode image:image from parent
	 * @param string $imageloc
	 */
	private function writeImageLoc($imageloc){
		$this->writer->startElement('image:image');// [2] Second Node
		$this->writer->writeElement('image:loc',magixcjquery_filter_isVar::isURL(magixcjquery_filter_var::escapeHTML($imageloc)));
		$this->writer->endElement();
	}
	/**
	 * create childnode url
	 * @param URL $loc
	 * @param void $writeImageLoc
	 */
	public function writeMakeNodeImage($loc,$imageloc,$uri='',$forimage=false){
		if($this->validElement($loc) == true){
			$this->writer->startElement('url');// [2] Second Node
			$this->writer->writeElement('loc',magixcjquery_filter_isVar::isURL(magixcjquery_filter_var::escapeHTML($loc)));
			if($forimage != false){
				foreach($forimage as $img){
					if($img[$imageloc] != NULL){
						self::writeImageLoc($uri.$img[$imageloc]);
					}
				}
			}else{
				self::writeImageLoc($uri.$imageloc);
			}
			$this->writer->endElement();
		}
	}
	/**
	 * End Parent element
	 * @return end 
	 */
	public function endWrite(){
		magixcjquery_xml_xml::xmlInstance()->endElement();
	}
	/**
	 * Create GZ file from sitemap.xml
	 * @param $file
	 * @param $data
	 * @return void
	 */
	public function createGZ($fpath,$file,$data){
		$this->makeFile(
			magixcjquery_xml_xml::xmlInstance()->folder_path($fpath).$file,
			magixcjquery_xml_xml::xmlInstance()->folder_path($fpath).$data
		);
	}
	/**
	 * 
	 * @param $url
	 * @param $file
	 * @return Send Sitemap Google webmaster
	 */
	public function sendSitemapGoogle($url,$file){
		self::googlePing($url,$file);
	}
}