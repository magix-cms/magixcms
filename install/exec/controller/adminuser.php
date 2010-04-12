<?php
/**
 * @category   Controller
 * @package    install
 * @copyright  Copyright Magix CMS (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name user
 *
 */
class exec_controller_adminuser extends dbinstuser{
	/**
	 * pseudo
	 * @var string $pseudo
	 */
	public $pseudo;
	/**
	 * pseudo
	 * @var string $pseudo
	 */
	public $email;
	/**
	 * pseudo
	 * @var string $pseudo
	 */
	public $cryptpass;
	/**
	 * constructor
	 * 
	 */
	function __construct(){
		if(isset($_POST['pseudo'])){
			$this->pseudo = magixcjquery_form_helpersforms::inputClean($_POST['pseudo']);
		}
		if(isset($_POST['email'])){
			$this->email = magixcjquery_form_helpersforms::inputClean($_POST['email']);
		}
		if(isset($_POST['cryptpass'])){
			$this->cryptpass = magixcjquery_form_helpersforms::inputClean(sha1($_POST['cryptpass']));
		}
	}
	protected function insert_admin_members(){
		if(isset($this->pseudo) AND isset($this->cryptpass) AND isset($this->email)){
			if(!empty($this->email)){
				parent::cuser()->i_useradmin($this->pseudo,$this->email,$this->cryptpass);
				//exec_config_smarty::getInstance()->display('request/success-user.phtml');
			}
		}
	}
	public function display_user_page(){
		exec_config_smarty::getInstance()->display('user.phtml');
	}
	public function display_completes_install(){
		self::insert_admin_members();
		exec_config_smarty::getInstance()->display('end.phtml');
	}
}
class dbinstuser{
	/**
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 * @access protected
	 */
	protected $layer;
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $cuser;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
	/**
	 * instance frontend_db_news with singleton
	 */
	public static function cuser(){
        if (!isset(self::$cuser)){
         	self::$cuser = new dbinstuser();
        }
    	return self::$cuser;
    }
	public function i_useradmin($pseudo,$email,$cryptpass){
		$sql = array(
			'INSERT INTO mc_admin_member (pseudo,email,cryptpass) VALUE("'.$pseudo.'","'.$email.'","'.$cryptpass.'")',
			'INSERT INTO mc_admin_perms (perms) VALUE("1")'
		);
		$this->layer->transaction($sql);
	}
}