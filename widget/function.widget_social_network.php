<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_social_network} function plugin
 *
 * Type:     function
 * Name:     widget_get_social
 * Date:     18-07-2011
 * Update:
 * Purpose:  Display social bookmark
 * Examples:{widget_social_network title=$subjectpage size='small'}
 * Output:   
 * @link 	http://www.magix-dev.be
 * @author   Gerits Aurélien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_social_network($params, $template){
	$parsed = $_SERVER["REQUEST_URI"];
	//strrpos récupère la dernière occurence de / et de .
    $slashpos = strrpos($parsed,'/');
	/**
	 * Si title n'est pas défini on retourne une erreur
	 * @return string
	 */
	if (!isset($params['title'])) {
	 	//trigger_error("Missing parameter :title");
		return;
	}
	/**
	 * Si size n'est pas défini on retourne une erreur
	 * @return string
	 */
	if (!isset($params['size'])) {
	 	//trigger_error("Missing parameter :size");
	 	return;
	}
	/**
	 * Si le paramètre title est vide on retourne ''
	 * @var $paramTitle string
	 */
	$paramTitle = empty($params['title']) ? '' : $params['title'];
	/**
	 * Si le paramètre size est vide on retourne medium
	 * @var $paramSize string
	 */
	$paramSize = empty($params['size']) ? 'medium' : $params['size'];     
    $title = urlencode($paramTitle);
    $url = magixcjquery_html_helpersHtml::getUrl();
    $fbstr = 'http://www.facebook.com/share.php?u='.$url.$parsed;
    $twstr = 'http://twitthis.com/twit?url='.$url.$parsed.'&amp;title='.$title;
    $viastr = 'http://www.viadeo.com/shareit/share/?url='.$url.$parsed.'&amp;title='.$title.'&amp;overview='.$title;
        if(isset($paramSize)){ 
			if(isset($paramSize)){
				switch($paramSize){
					case 'small':
						$imgfb = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Facebook-16.png';
						$imgtw = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Twitter-1-16.png';
						$imgvia = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/viadeo_16.png';
						break;
					case 'medium':
						$imgfb = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Facebook-32.png';
						$imgtw = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Twitter-1-32.png';;
						$imgvia = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/viadeo_32.png';
						break;
					case 'large':
						$imgfb = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Facebook-48.png';
						$imgtw = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/Twitter-1-48.png';;
						$imgvia = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/socialnetwork/viadeo_48.png';
						break;
				}
			}
		    $arr = array($imgfb, $imgtw,$imgvia);
            $socialmenu = '<div id="getsocialize">';
            $socialmenu .= '<p>';
            $socialmenu .= "<a class='targetblank float-left' href='".$fbstr."'><img src='".$arr[0]."' alt='".$title."' title='Partager sur Facebook' /></a>";
            $socialmenu .= "<a class='targetblank float-left' href='".$twstr."'><img src='".$arr[1]."' alt='".$title."' title='Partager sur Twitter' /></a>";
            $socialmenu .= "<a class='targetblank float-left' href='".$viastr."'><img src='".$arr[2]."' alt='".$title."' title='Partager sur Viadeo' /></a>";
            $socialmenu .= "<a id='googlebtn' href='#'></a>";			
            $socialmenu .= "</p>";
            $socialmenu .= '</div>';
		}  
	return $socialmenu;
}