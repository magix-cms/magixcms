<?php
/**
 * @category   config
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * Configuration / extends smarty with class
 *
 */
$pathdir = dirname(realpath( __FILE__ ));
$arraydir = array('app\backend\config', 'app/backend/config');
$smartydir = magixglobal_model_system::root_path($arraydir,array('lib\smarty3', 'lib/smarty3') , $pathdir);
$inc = $smartydir.'/Smarty.class.php';
if (file_exists($inc)) {
	require_once($inc);
}else{
	exit();
}
//if(!defined('REQUIRED_SMARTY_DIR')) define('REQUIRED_SMARTY_DIR','./');
/**
 * Extend class smarty
 *
 */
class backend_config_smarty extends Smarty{
	/**
    * Variable statique permettant de porter l'instance unique
    */
    static protected $instance;
	/**
	 * function construct class
	 *
	 */
	public function __construct(){
		/**
		 * include parent var smarty
		 */
		parent::__construct(); 
		self::setParams();
		/*
		 You can remove this comment, if you prefer this JSP tag style
		 instead of the default { and }
		 $this->left_delimiter =  '<%';
		 $this->right_delimiter = '%>';
		 */
	}
	private function setPath(){
		$pathdir = dirname(realpath( __FILE__ ));
		$arraydir = array('app\backend\config', 'app/backend/config');
		return $smartydir = magixglobal_model_system::root_path($arraydir,array('', '') , $pathdir);
	}
	protected function setParams() {
		/**
		 * Path -> configs
		 */
		$this->config_dir = self::setPath()."/app/backend/local/";
		/**
		 * Path -> templates
		 */
		$this->template_dir = array(self::setPath()."/framework/skin/backend/");
		/**
		 * path plugins
		 * @var void
		 */
		$this->plugins_dir = array(
			self::setPath().'/lib/smarty3/plugins/'
			,self::setPath().'/app/extends/core/'
			,self::setPath().'/app/extends/backend/'
		);
		/**
		 * Path -> compile
		 */
		$this->compile_dir = self::setPath()."/var/tpl_admin/";
		/**
		 * debugging (true/false)
		 */
		$this->debugging = false;
		/**
		 * compile (true/false)
		 */
		$this->compile_check = true;
		/**
		 * Force compile
		 * @var void
		 * (true/false)
		 */
		$this->force_compile = false;
		/**
		 * caching (true/false)
		 */
		$this->caching = false;
		/**
		 * Use sub dirs (true/false)
		 */
		$this->use_sub_dirs = false;
		/**
		 * cache_dir -> cache
		 */
		$this->cache_dir = self::setPath().'/var/tmp/';
		/**
		 * Security
		 */
		$this->security = false;
		/**
		 * load pre filter
		 */
		//$this->load_filter('pre','magixmin');
		$this->autoload_filters = array('pre' => array('magixmin'));
		/**
		 * security settings
		 */
		/*$this->security_settings = array(
                                    'PHP_HANDLING'    => false,
                                    'IF_FUNCS'        => array('array', 'list',
                                                               'isset', 'empty',
                                                               'count', 'sizeof',
                                                               'in_array', 'is_array',
                                                               'true', 'false', 'null'),
                                    'INCLUDE_ANY'     => false,
                                    'PHP_TAGS'        => false,
                                    'MODIFIER_FUNCS'  => array('count'),
                                    'ALLOW_CONSTANTS'  => false,
                                    'ALLOW_SUPER_GLOBALS' => true
	);*/
	}
	public static function getInstance(){
        if (!isset(self::$instance))
      {
         self::$instance = new backend_config_smarty();
      }
    	return self::$instance;
    }
}
?>
