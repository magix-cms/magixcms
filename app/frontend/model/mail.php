<?php
/**
 * @category   Model Class mail
 * Model extends PHPMailer
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * Class mail simple processing
 * @author Aurelien
 *
 */
class frontend_model_mail extends PHPMailer{
	/**
	 * instance global phpmailer
	 * @var mail
	 */
	public $mail;
	public $From     = '';
    public $FromName = '';
	public $WordWrap = 100;
	/**
	 * construct class
	 * @return void
	 */
	function __construct(){
		/*
		* Instance phpmailer
		*/
		$this->mail = new PHPMailer();
		/**
		 * 
		 */
	}
	/**
	 * config language for phpmailer message
	 * @return void
	 */
	private function mail_config_language(){
		if(isset($_SESSION['strLangue'])){
			$lang = $_SESSION['strLangue'];
		}else{
			$lang = 'fr';
		}
		$this->mail->SetLanguage($lang, $_SERVER['DOCUMENT_ROOT']."/lib/phpmailler/language/");
	}
	/**
	 * extract domain
	 * exemple: http//www.mydomain.com => mydomain.com
	 */
	protected function extract_domain(){
		$parse = parse_url(magixcjquery_html_helpersHtml::getUrl(), PHP_URL_HOST);
		return substr($parse,4);
	}
	/**
	 * config header for phpmailer (text brut)
	 * @return void
	 */
	public function simple_mail_head(){
		$this->mail->IsMail();
		$this->mail->isHTML(false);
		$this->mail->Priority = 3;
		$this->mail->Encoding = "8bit";
		$this->mail->CharSet = "utf-8";
		$this->mail->From = "replyto@".self::extract_domain();
		$this->mail->FromName = parse_url(magixcjquery_html_helpersHtml::getUrl(), PHP_URL_HOST);//substr($_SERVER['HTTP_HOST'],0,-4);
		self::mail_config_language();
	}
	/**
	 * config header for phpmailer (html)
	 * @return void
	 */
	public function simple_mail_html_head(){
		$this->mail->IsMail();
		$this->mail->isHTML(true);
		$this->mail->Priority = 3;
		$this->mail->Encoding = "8bit";
		$this->mail->CharSet = "utf-8";
		$this->mail->From = "replyto@".self::extract_domain();
		$this->mail->FromName = parse_url(magixcjquery_html_helpersHtml::getUrl(), PHP_URL_HOST);//substr($_SERVER['HTTP_HOST'],0,-4);
		self::mail_config_language();
	}
	/**
	 * title for mail send with phpmailer
	 * @param $subject
	 * @return void
	 */
	public function mail_subject($subject){
		$this->mail->Subject = $subject;
	}
	/**
	 * body for mail send with phpmailer
	 * @param $body
	 * @return void
	 */
	public function mail_body($body){
		$this->mail->Body = $body."\n";
	}
	/**
	 * add address for mail send with phpmailer
	 * @param $email
	 * @param $destinataire
	 * @return void
	 */
	public function mail_add_Address($email,$destinataire=false){
		$this->mail->AddAddress($email,$destinataire=false);
	}
	/**
	 * function submit mail
	 * @return void
	 */
	public function mail_submit(){
		if(!$this->mail->Send()) {
			$this->mail->ErrorInfo;
		}
	}
	/**
	 * clean submission
	 * @return void
	 */
	public function clean_Submit(){
		$this->mail->ClearAddresses();
		unset($this->mail);
	}
	/**
     * Récupération des mails utilisateurs et administrateurs
     */
    public function select_mail_user(){
    	if(frontend_db_member::dbMember()->s_members_user_states() != null){
	    	$mail = null;
	    	foreach(frontend_db_member::dbMember()->s_members_user_states() as $members){
	    		$mail .= self::mail_add_Address($members['email']);
	    	}
    	}else{
    		$mail = self::mail_add_Address('aurelien@web-solution-way.be');
    	}
    	return $mail;
    }
}
?>