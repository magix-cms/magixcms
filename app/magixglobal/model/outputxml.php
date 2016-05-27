<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2016 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com>
 #
 # Redistributions of files must retain the above copyright notice.
 # This program is free software: you can redistribute it and/or modify
 # it under the terms of the GNU General Public License as published by
 # the Free Software Foundation, either version 3 of the License, or
 # (at your option) any later version.
 #
 # This program is distributed in the hope that it will be useful,
 # but WITHOUT ANY WARRANTY; without even the implied warranty of
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 # GNU General Public License for more details.

 # You should have received a copy of the GNU General Public License
 # along with this program.  If not, see <http://www.gnu.org/licenses/>.
 #
 # -- END LICENSE BLOCK -----------------------------------

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   Model
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2008-2016 Gerits Aurelien,
 * http://www.magix-cms.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1
 * @author Aurelien Gerits
 * @name outputxml
 *
 */
class magixglobal_model_outputxml extends XMLWriter {
    
    /**
     * @var
     */
    protected $xmlwriter;

    /**
     * magixglobal_model_outputxml constructor.
     */
    function __construct(){
        $this->openMemory();
        $this->setIndent(true);
        $this->startDocument('1.0', 'UTF-8');
        $this->startElement('magixcms');
    }
    public function getXmlHeader(){
        header('Content-type: text/xml; charset=UTF-8');
    }
    /**
     * @param $data
     */
    public function setElement($data){
        $this->startElement($data['start']);
        if(array_key_exists('attr', $data)){
            // if attr is array
            if(is_array($data['attr'])){
                foreach($data['attr'] as $key => $value) {
                    if(is_array($value)){
                        $this->startAttribute($value['name']);
                        $this->text($value['content']);
                        $this->endAttribute();
                    }
                }
            }
        }
        if(array_key_exists('attrNS', $data)){
            // if attrNS is array
            if(is_array($data['attrNS'])){
                foreach($data['attrNS'] as $key => $value) {
                    if(is_array($value)) {
                        $this->startAttributeNS($value['prefix'], $value['name'], $value['uri']);
                        $this->text($value['uri']);
                        $this->endAttribute();
                    }
                }
            }
        }
        if(array_key_exists('cData', $data)){
            $this->writeCData($data['cData']);
        }
        if(array_key_exists('text',$data)){
            $this->text($data['text']);
        }
        $this->endElement();
    }

    /**
     * @param $name
     */
    public function newStartElement($name){
        $this->startElement($name);
    }

    /**
     * End root Element
     */
    public function newEndElement(){
        $this->endElement();
    }

    /**
     * Output document
     */
    public function output(){
        $this->endElement();
        $this->endDocument();
        print $this->outputMemory(TRUE);
    }
}
?>