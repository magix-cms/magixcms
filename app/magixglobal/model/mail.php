<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
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
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> | <gerits.aurelien@gmail.com>
 * @name mail
 *
 */
class magixglobal_model_mail{
	/**
	 * 
	 * instance $_mailer
	 * @var $_mailer
	 */
	protected $_mailer;
	/**
	 * 
	 * défini les options de transport
	 * @var $_transport_options
	 */
	protected $_transport_options = array(
		        'setHost'		=>	'',
		        'setPort'		=>	25,
				'setEncryption'	=>	'',
				'setUsername'	=>	'',
				'setPassword'	=>	''
			);
	/**
	 * 
	 * Constructor
	 * @param string $type
	 * @param array $options
	 */
	public function __construct($type,$Options=null){
		$this->_mailer = Swift_Mailer::newInstance(self::transportConfig($type,$Options));
	}
	/**
   * Get options from the library
   *
   * @return array The currently set options
   */
	private function getOptions() {
		return $this->_transport_options;
	}
    /**
     * INI transport
     * @param string $type
     * @param string $host
     * @param integer $port
     * @access public
     * @static
     */
    private function transportConfig($type,$Options){
    	switch ($type){
    		case 'mail':
    			$config = Swift_MailTransport::newInstance();
    		break;
    		case 'smtp':
		    	if($Options) {
			      if(!is_array($Options)) {
			        throw $this->newException('Options must be defined as an array!');
			      }
			      else {
			      	
			      	$config = Swift_SmtpTransport::newInstance()
				      	->setHost($Options["setHost"])
	  					->setPort($Options["setPort"])
	  					->setEncryption($Options["setEncryption"])
				      	->setUsername($Options["setUsername"])
						->setPassword($Options["setPassword"]);
			      }
			    }else{
			    	$config = Swift_SmtpTransport::newInstance(self::getOptions());
			    }
    		break;
    	}
    	return $config;
    }
   /**
    * Le contenu du message (email,sujet,contenu,...)
    * @param void $sw_message
    * @param string $subject
    * @param string $from
    * @param string $recipient
    * @param string $bodyhtml
    * @param string $bodytxt
    * @access public
    * @static
    */
	public function body_mail($subject,$from=array(),$recipient=array(),$bodyhtml,$setReadReceiptTo=false){
		$sw_message = Swift_Message::newInstance();
		$sw_message->getHeaders()->get('Content-Type')->setValue('text/html');
		$sw_message->getHeaders()->get('Content-Type')->setParameter('charset', 'utf-8');
		$sw_message->setSubject($subject)
		       ->setEncoder(Swift_Encoding::get8BitEncoding())
		       ->setFrom($from)
		       ->setTo($recipient)
		       ->setBody($bodyhtml,'text/html')
		       ->addPart(magixcjquery_form_helpersforms::inputTagClean($bodyhtml),'text/plain');
		if($setReadReceiptTo){
			$sw_message->setReadReceiptTo($setReadReceiptTo);
		}
		return $sw_message;
    }
	/**
    * Plugin decorator 
    * @param void $mailer
    * @param string replacement
    */
    public function plugin_decorator($replacements){
    	$decorator = new Swift_Plugins_DecoratorPlugin($replacements);
		$this->_mailer->registerPlugin($decorator);
    }
    /**
    * Plugin antiflood 
    * @param void $mailer
    * @param string $threshold
    * @param $sleep
    */
	public function plugin_antiflood($threshold, $sleep){
    	//Use AntiFlood to re-connect after 100 emails specify a time in seconds to pause for (30 secs)
		$antiflood = new Swift_Plugins_AntiFloodPlugin($threshold, $sleep);
		$this->_mailer->registerPlugin($antiflood);
    }
    /**
    * Plugin throttler 
    * @param void $mailer
    * @param $rate
    * @param $mode
    */
	public function plugin_throttler($rate,$mode){
    	//Use AntiFlood to re-connect after 100 emails specify a time in seconds to pause for (30 secs)
		$throttler = new Swift_Plugins_ThrottlerPlugin($rate,$mode);
		//Rate limit to 10MB per-minute OR Rate limit to 100 emails per-minute
		$this->_mailer->registerPlugin($throttler);
    }
    /**
     * fusion des plugins anti flood et throttler pour un envoi de masse
     * @param void $mailer
     * @param integer $threshold
     * @param integer $sleep
     * @param string $throttlermode
     */
    public function plugins_massive_mailer($threshold = 100, $sleep = 10,$throttlermode = 'bytes'){
    	try {
	    	switch($throttlermode){
	    		case "bytes" :
	    			$rate = 1024 * 1024 * 10;
	    			$mode = Swift_Plugins_ThrottlerPlugin::BYTES_PER_MINUTE;
	    			break;
	    		case "messages" :
	    			$rate = 100;
	    			$mode = Swift_Plugins_ThrottlerPlugin::MESSAGES_PER_MINUTE;
	    			break;
	    		default:
	    			$rate = 100;
	    			$mode = Swift_Plugins_ThrottlerPlugin::MESSAGES_PER_MINUTE;
	    			break;
	    	}
	    	if(!empty($threshold) AND !empty($sleep) AND !empty($throttlermode)){
	    		if(!is_numeric($threshold)){
	    			throw new Exception("threshold is not numeric");
	    		}elseif(!is_numeric($sleep)){
	    			throw new Exception("sleep is not numeric");
	    		}else{
	    			$this->plugin_antiflood($threshold, $sleep);
					$this->plugin_throttler($rate, $mode);
	    		}
	    	}
    	}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
    }
 	/**
     * Envoi du message avec la méthode batch send
     * @param void $mailer
     * @param string $message
     * @param void $failed
     * @param string $logger
     */
    public function batch_send_mail($message,$failures=false,$log=false){
    	if(!$this->_mailer->send($message)){
    		magixcjquery_debug_magixfire::magixFireDump("Failures: ", $failures);
    	}
    	if($log){
	    	$echologger = new Swift_Plugins_Loggers_EchoLogger();
			$this->_mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($echologger));
	    	magixcjquery_debug_magixfire::magixFireDump("Failures: ",$echologger->dump());
    	}
    }
}