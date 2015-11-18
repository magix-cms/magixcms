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
 * @link http://magix-cjquery.com
 * @copyright Magix cjQuery 2009 - 2012
 * @author : Gérits Aurélien
 * @package : pagination
 * @version 0.3
 *
 */
class magixcjquery_pager_pagination{
    /**
     * calculate page offset
     * @access public
     * @param int $limit
     * @param $getpage
     * @return int
     */
    public function pageOffset($limit=10,$getpage){
        return $limit * (abs($getpage)-1);
    }

    /**
     * @calculate paging information
     * @access public
     * @param void $request
     * @param $as
     * @param int $limit
     * @param $getpage
     * @param bool $url
     * @param bool $host
     * @param bool $rewrite
     * @param null $namepage
     * @param bool $debug
     * @internal param object $page
     * @return object
     * @depreciated
     */

    function pagerData($request,$as,$limit=10,$getpage,$url=false,$host=false,$rewrite=false,$namepage=null,$debug=false){
        $num = '';
        foreach ($request as $t) $num_pages = $t[$as];
        $num_pages = ceil($num_pages/$limit);
        $page = max($getpage, 1);
        $page = min($getpage, $num_pages);
        if($getpage > $limit || $getpage <= 0) {
            $page = 1;
        }
        $debug?self::debugPager($page,$num_pages,$limit,$getpage):false;
        $offset = $getpage;
        if($offset > $num_pages)
        {
          $offset = $num_pages;
        }
        $offset = $this->pageOffset($limit,$getpage);
        switch($rewrite){
            case false :
                $rewrite = $namepage.'=';
            break;
            case true :
                $rewrite = $namepage.'/';
            break;
            case 'none':
                $rewrite = $namepage;
            break;
        }
        if($getpage > 1)
            {
                $num .= '<a href="'.$url.$rewrite.(min($getpage, 1)).$host.'">&#171;&#171;</a>';
                $num .= '<a href="'.$url.$rewrite.($getpage - 1).$host.'">&#171;</a>';
            }
            if ( $num_pages > 20 ){
                $points = false;
                for ( $i = 1; $i <= $num_pages; $i++ ){
                  if ( $i == $getpage ) {
                    $num .= '<div class="current">'.$i.'</div>';
                  }elseif ( abs( $i - $getpage ) <= 10 || $i == 1 || $i == $num_pages ) {
                    $num .= '<a href="'.$url.$rewrite.$i.$host.'">'.$i.'</a>';
                    $points = false;
                  }elseif ( $points == false ) {
                    $num .= '<div class="pagedelimiter">...</div>';
                    $points = true;
                  }
                }
            }else{
                if($num_pages > 1){
                    for($i=1; $i<=$num_pages; $i++){
                        if($i == $getpage){
                           $num .= '<div class="current">'.$i.'</div>';
                        }else{
                          $num .= '<a href="'.$url.$rewrite.$i.$host.'">'.$i.'</a>';
                        }
                    }
                }
            }
        if ($getpage < $num_pages)  {
            $num .= '<a href="'.$url.$rewrite.($getpage + 1).$host.'">&#187;</a>';
            $num .= '<a href="'.$url.$rewrite.max($getpage, $num_pages).$host.'">&#187;&#187;</a>';
        }
        return $num;
    }

    /**
     * @param $getdata
     * @param int $limit
     * @param array $setConfig
     * @param array $setArrow
     * @param array $css_param
     * @param bool $debug
     * @return string
     * @example:
     *
    $max = 10
    $pagination = new magixcjquery_pager_pagination();
    $pagination->pageOffset($max,$_GET['page']);
    $request = s_count_data_pager();
    $setConfig = array(
        'url'=>'http://www.mydomain/mypage/',
        'getPage'=> $this->getpage,
        'seo'=>'dash',
        'pageName'=>'page',
        'pageNumber'=> false,
        'pageNumberLight'=>true,
        'arrow'=>true,
        'arrowthick'=>false
    );
    $setArrow = array('left'=>'Précédent','right'=>'Suivant');
    $css_param = array('class_number'=>'block w2-16 lfloat','class_arrow_left'=>'button lfloat block w2-16','class_arrow_right'=>'button lfloat block w2-16 last');
    $pagerdata = $pagination->setPagerData(
        $request['total'],$max,$setConfig,$setArrow,$css_param
    );
    $block = '<div class="block w7-16 rfloat pagination last">';
    $block .= $pagerdata;
    $block .= '</div>';
    print $block
     */
    public function setPagerData($getdata,$limit=10,$setConfig = array('url'=>'','getPage'=> '','seo'=>'dash', 'pageName'=>'','uriOption'=>'','pageNumber'=> true, 'pageNumberLight'=> false,'arrow'=>true,'arrowthick'=>true),$setArrow = array('left'=>'&#171;','thickleft'=>'&#171;&#171;','right'=>'&#187;','thickright'=>'&#187;&#187;'),$css_param = array('class_current'=>'current','class_delimiter'=>'delimiter','class_number'=>'number','class_arrow_left'=>'','class_arrowthick_left'=>'','class_arrow_right'=>'','class_arrowthick_right'=>''),$debug=false){
        if(is_array($setConfig)){
            if(array_key_exists('seo', $setConfig)){
                $seoConfig = $setConfig['seo'];
            }else{
                $seoConfig = 'dash';
            }
            if(array_key_exists('uriOption', $setConfig)){
                $uriOption = $setConfig['uriOption'];
            }else{
                $uriOption = '';
            }
            if(array_key_exists('pageNumber', $setConfig)){
                $pageNumber = $setConfig['pageNumber'];
            }else{
                $pageNumber = true;
            }
            if(array_key_exists('pageNumberLight', $setConfig)){
                $pageNumberLight = $setConfig['pageNumberLight'];
            }else{
                $pageNumberLight = false;
            }
            if(array_key_exists('arrow', $setConfig)){
                $arrow = $setConfig['arrow'];
            }else{
                $arrow = true;
            }
            if(array_key_exists('arrowthick', $setConfig)){
                $arrowthick = $setConfig['arrowthick'];
            }else{
                $arrowthick = true;
            }
            $num_pages = $getdata;
            $num_pages = ceil($num_pages/$limit);
            $page = max($setConfig['getPage'], 1);
            $page = min($setConfig['getPage'], $num_pages);
            if($setConfig['getPage'] > $limit || $setConfig['getPage'] <= 0) {
                $page = 1;
            }
            if($debug != false){
                self::debugPager($page,$num_pages,$limit,$setConfig['getPage']);
            }
            $offset = $setConfig['getPage'];
            if($offset > $num_pages)
            {
                $offset = $num_pages;
            }
            $offset = $this->pageOffset($limit,$setConfig['getPage']);
            switch($seoConfig){
                case 'dash':
                    $seo = $setConfig['pageName'].'-';
                    break;
                case 'none':
                    $seo = $setConfig['pageName'].'=';
                    break;
                case 'slash':
                    $seo = $setConfig['pageName'].'/';
                    break;
                default:
                    $seo = $setConfig['pageName'];
                break;
            }
            $pager = '';
            if(array_key_exists('class_arrow_left', $css_param)){
                if($css_param['class_arrow_left'] != ''){
                    $class_arrow_left = ' class="'.$css_param['class_arrow_left'].'" ';
                }else{
                    $class_arrow_left = '';
                }
            }else{
                $class_arrow_left = '';
            }
            if(array_key_exists('class_arrowthick_left', $css_param)){
                if($css_param['class_arrowthick_left'] != ''){
                    $class_arrowthick_left = ' class="'.$css_param['class_arrowthick_left'].'" ';
                }else{
                    $class_arrowthick_left = '';
                }
            }else{
                $class_arrowthick_left = '';
            }
            if(array_key_exists('class_arrow_right', $css_param)){
                if($css_param['class_arrow_right'] != ''){
                    $class_arrow_right = ' class="'.$css_param['class_arrow_right'].'" ';
                }else{
                    $class_arrow_right = '';
                }
            }else{
                $class_arrow_right = '';
            }
            if(array_key_exists('class_arrowthick_right', $css_param)){
                if($css_param['class_arrowthick_right'] != ''){
                    $class_arrowthick_right = ' class="'.$css_param['class_arrowthick_right'].'" ';
                }else{
                    $class_arrowthick_right = '';
                }
            }else{
                $class_arrowthick_right = '';
            }
            if($pageNumberLight == true){
                $pager .= '<span class="'.$css_param['class_number'].'">';
                $pager .= ' Page ';
                //$pager .=  min($setConfig['getPage'], 1);
                $pager .=  $setConfig['getPage'];
                $pager .= ' sur ';
                $pager .=  max($setConfig['getPage'], $num_pages);
                $pager .= '</span>';
            }
            if($setConfig['getPage'] > 1)
            {
                if($arrowthick == true){
                    $pager .= '<a'.$class_arrowthick_left.' href="'.$setConfig['url'].$seo.(min($setConfig['getPage'], 1)).$setConfig['uriOption'].'">'.$setArrow['thickleft'].'</a>';
                }
                if($arrow == true){
                    $pager .= '<a'.$class_arrow_left.' href="'.$setConfig['url'].$seo.($setConfig['getPage'] - 1).$setConfig['uriOption'].'">'.$setArrow['left'].'</a>';
                }
            }
            if($pageNumber == true){
                if ( $num_pages > 20 ){
                    $points = false;
                    for ( $i = 1; $i <= $num_pages; $i++ ){
                        if ( $i == $setConfig['getPage'] ) {
                            $pager .= '<span class="'.$css_param['class_current'].'">'.$i.'</span>';
                        }elseif ( abs( $i - $setConfig['getPage'] ) <= 10 || $i == 1 || $i == $num_pages ) {
                            $pager .= '<a href="'.$setConfig['url'].$seo.$i.$uriOption.'">'.$i.'</a>';
                            $points = false;
                        }elseif ( $points == false ) {
                            $pager .= '<span class="'.$css_param['class_delimiter'].'">...</span>';
                            $points = true;
                        }
                    }
                }else{
                    if($num_pages > 1){
                        for($i=1; $i<=$num_pages; $i++){
                            if($i == $setConfig['getPage']){
                                $pager .= '<span class="'.$css_param['class_current'].'">'.$i.'</span>';
                            }else{
                                $pager .= '<a href="'.$setConfig['url'].$seo.$i.$uriOption.'">'.$i.'</a>';
                            }
                        }
                    }
                }
            }
            if ($setConfig['getPage'] < $num_pages)  {
                if($arrow == true){
                    $pager .= '<a'.$class_arrow_right.' href="'.$setConfig['url'].$seo.($setConfig['getPage'] + 1).$uriOption.'">'.$setArrow['right'].'</a>';
                }
                if($arrowthick == true){
                    $pager .= '<a'.$class_arrowthick_right.' href="'.$setConfig['url'].$seo.max($setConfig['getPage'], $num_pages).$uriOption.'">'.$setArrow['thickright'].'</a>';
                }
            }
            return $pager;
        }
    }
	  /**
	   * function debug pagination
	   *
	   * @param void $page
	   * @param void $num_pages
	   * @param int $limit
	   * @param void $getpage
	   */
	  private function debugPager($page,$num_pages,$limit,$getpage){
	  	/*debug*/
	  	if(defined('M_LOG')){
			if(M_LOG == 'debug' AND M_FIREPHP == true){
			  	$FirePHPOpt =  array('Collapsed' => false,'Color' => '#FF772F');
			  	magixcjquery_debug_magixfire::magixFireGroup('Test pagination',$FirePHPOpt);
		        magixcjquery_debug_magixfire::magixFireLog($page,'Page');
		        magixcjquery_debug_magixfire::magixFireLog($num_pages,'Page number');
		        magixcjquery_debug_magixfire::magixFireLog($limit,'Limit');
				magixcjquery_debug_magixfire::magixFireGroupEnd();
				$page = max($getpage, 1);
				magixcjquery_debug_magixfire::magixFireGroup('Test pagination',$FirePHPOpt);
		        magixcjquery_debug_magixfire::magixFireLog($page,'Page');
		        magixcjquery_debug_magixfire::magixFireLog($num_pages,'Page number');
		        magixcjquery_debug_magixfire::magixFireLog($limit,'Limit');
				magixcjquery_debug_magixfire::magixFireGroupEnd();
				$page = min($getpage, $num_pages);
				magixcjquery_debug_magixfire::magixFireGroup('Test pagination',$FirePHPOpt);
		        magixcjquery_debug_magixfire::magixFireLog($page,'Page');
		        magixcjquery_debug_magixfire::magixFireLog($num_pages,'Page number');
		        magixcjquery_debug_magixfire::magixFireLog($limit,'Limit');
				magixcjquery_debug_magixfire::magixFireGroupEnd();
			  	if($getpage > $limit || $getpage <= 0) {
					$page = 1;
				}
				magixcjquery_debug_magixfire::magixFireGroup('Test pagination',$FirePHPOpt);
		        magixcjquery_debug_magixfire::magixFireLog($page,'Page');
		        magixcjquery_debug_magixfire::magixFireLog($num_pages,'Page number');
		        magixcjquery_debug_magixfire::magixFireLog($limit,'Limit');
				magixcjquery_debug_magixfire::magixFireGroupEnd();
			}
	  	}else{
			print 'Page : '.$page.'<br />Num_Pages : '.$num_pages.'<br />Limit : '.$limit.'##########<br />';
			$page = max($getpage, 1);
			print 'Page : '.$page.'<br />Num_Pages : '.$num_pages.'<br />Limit : '.$limit.'##########<br />';
			$page = min($getpage, $num_pages);
			print 'Page : '.$page.'<br />Num_Pages : '.$num_pages.'<br />Limit : '.$limit.'##########<br />';
			if($getpage > $limit || $getpage <= 0) {
				$page = 1;
			}
			print 'Page : '.$page.'<br />Num_Pages : '.$num_pages.'<br />Limit : '.$limit.'##########<br />';
	  	}
	  }
	  /**
	   * class pagination FirstString
	   *
	   * @param first letters $firstlt
	   * @param sql $request
	   * @param $key
	   * @param string $url
	   * @return void
	   */
	function pagerString($firstlt,$request,$key,$rewrite='current',$url=false){
		$lt_tampon = -1;
		$lt = null;
		//$rewrite = $url ? $url.$key.'/' : '?'.$key.'=';
		if ($rewrite == 'rewrite') {
			$urlreq = $_SERVER['PHP_SELF'];
			$point = strpos($urlreq,'.');
			$subst = substr($urlreq, 0, $point);
			$rewrite = $subst.'/'.$url.'/'.$key.'/';
		}elseif($rewrite == 'current'){
			$rewrite = $_SERVER['PHP_SELF'].'?'.$url.'=';
		}
		foreach($request as $l){
				$let = $l[$key];
				if ($let == $firstlt){
					$lt .= '<div class="current">'.magixcjquery_string_convert::upTextCase($firstlt).'</div>';
				}else{
					$lt .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().$rewrite.$let.'">'.magixcjquery_string_convert::upTextCase($l[$key]).'</a>';
				}
				//letters prev diff letters next
				if ($lt!= $lt_tampon)
				{
					// Save new letters
					$lt_tampon .= $lt;
				}
		}
		return $lt;
	}
} /*** end of class ***/
?>