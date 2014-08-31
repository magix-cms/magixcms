<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
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
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2013 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    4.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name news
 *
 */
class backend_controller_news extends backend_db_news{
    protected $model_access,$message;
	/**
	 * 
	 * @var integer
	 */
	public $edit;
	/**
	 * 
	 * @var string
	 */
	public $n_title;
	/**
	 * 
	 * @var string
	 */
	public $n_uri;
	/**
	 * 
	 * @var string
	 */
	public $n_content,$idadmin;
	/**
	 * 
	 * @var string
	 */
	public $idlang;
	public $n_image;
	/**
	 * 
	 * @var string
	 */
	public $published;
	/**
	 * 
	 * @var intéger
	 */
	public $getpage;
	/**
	 * 
	 * @var intéger
	 */

	public $idnews,$delete_news,$delete_image,$name_tag,$delete_tag,$action,$tab,$getlang,$plugin;
	/**
	 * Recherche dans les news
	 */
	public $get_search_news,$news_search;
	/**
	 * 
	 * 
	 */
	public function __construct(){
        if(class_exists('backend_model_access')){
            $this->model_access = new backend_model_access();
        }
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
        if(magixcjquery_filter_request::isSession('keyuniqid_admin')){
            $this->idadmin = magixcjquery_filter_isVar::isPostNumeric($_SESSION['id_admin']);
        }
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('tab')){
            $this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
        }
		if(magixcjquery_filter_request::isGet('edit')){
			$this->edit = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
        if(magixcjquery_filter_request::isGet('getlang')){
            $this->getlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getlang']);
        }
        if(magixcjquery_filter_request::isPost('idnews')){
            $this->idnews = magixcjquery_filter_isVar::isPostNumeric($_POST['idnews']);
        }
		if(magixcjquery_filter_request::isPost('n_title')){
			$this->n_title = magixcjquery_form_helpersforms::inputClean($_POST['n_title']);
		}
		if(magixcjquery_filter_request::isPost('n_uri')){
			$this->n_uri = magixcjquery_url_clean::rplMagixString($_POST['n_uri']);
		}
		if(magixcjquery_filter_request::isPost('n_content')){
			$this->n_content = ($_POST['n_content']);
		}
		if(isset($_FILES['n_image']["name"])){
			$this->n_image = magixcjquery_url_clean::rplMagixString($_FILES['n_image']["name"]);
		}
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->idlang = magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(magixcjquery_filter_request::isGet('page')) {
				// si numéric
		      if(is_numeric($_GET['page'])){
		          $this->getpage = intval($_GET['page']);
		      }else{
		      	// Sinon retourne la première page
		          $this->getpage = 1;        
		           }
		 }else {
		    $this->getpage = 1;
		}
		if(magixcjquery_filter_request::isPost('published')){
			$this->published = magixcjquery_filter_isVar::isPostNumeric($_POST['published']);
		}
		if(magixcjquery_filter_request::isPost('delete_news')){
			$this->delete_news = magixcjquery_filter_isVar::isPostNumeric($_POST['delete_news']);
		}
        if(magixcjquery_filter_request::isPost('delete_image')){
            $this->delete_image = magixcjquery_filter_isVar::isPostNumeric($_POST['delete_image']);
        }
		/**
		 * Système de tags
		 */
		if(magixcjquery_filter_request::isPost('name_tag')){
			$this->name_tag = (string) magixcjquery_url_clean::make2tagString($_POST['name_tag']);
		}
		if(magixcjquery_filter_request::isPost('delete_tag')){
			$this->delete_tag = magixcjquery_form_helpersforms::inputClean($_POST['delete_tag']);
		}
		//SEARCH
		if(magixcjquery_filter_request::isGet('get_search_news')){
			$this->get_search_news = magixcjquery_form_helpersforms::inputClean($_GET['get_search_news']);
		}
		if(magixcjquery_filter_request::isPost('news_search')){
			$this->news_search = magixcjquery_form_helpersforms::inputClean($_POST['news_search']);
		}
        //plugin
        if(magixcjquery_filter_request::isGet('plugin')){
            $this->plugin = magixcjquery_form_helpersforms::inputClean($_GET['plugin']);
        }
	}
    /**
     * @access private
     * Génération d'un identifiant alphanumérique avec une longueur définie
     * @param integer $numString
     * @return string
     */
    private function extract_random_idnews($numString){
        return magixglobal_model_cryptrsa::short_alphanumeric_id($numString);
    }
    /**
     * offset for pager in pagination
     * @param $max
     * @return int
     * @deprecated
     */
    private function offset_pager($max){
        $pagination = new magixcjquery_pager_pagination();
        return $pagination->pageOffset($max,$this->getpage);
    }

    /**
     * Construction de la pagination
     * @param $max
     * @return string
     * @deprecated
     */
    /*private function news_pager($max){
        $role = new backend_model_role();
        $pagination = new magixcjquery_pager_pagination();
        $request = parent::s_count_max_news($this->getlang,$role->sql_arg());
        $setConfig = array(
            'url'=>'/admin/news.php?getlang='.$this->getlang.'&amp;action=list&amp;',
            'getPage'=> $this->getpage,
            'seo'=>'none',
            'pageName'=>'page',
            'pageNumber'=> true,
            'pageNumberLight'=>false,
            'uriOption'=>false,
            'arrow'=>true,
            'arrowthick'=>true
        );
        return $pagination->setPagerData(
            $request['total'],$max,$setConfig
        );
    }*/

    /**
     * Retourne la pagination pour les actualités
     * @param $limit
     * @return null|string
     */
    private function news_pagination($limit){
        $role = new backend_model_role();
        $db = parent::s_count_max_news($this->getlang);
        $total = $db['total'];
        // *** Set pagination
        $dataPager = null;
        if (isset($total) AND isset($limit)) {
            $lib_rewrite = new magixglobal_model_rewrite();
            $basePath = '/'.PATHADMIN.'/news.php?getlang='.$this->getlang.'&amp;action=list&amp;';
            $dataPager = magixglobal_model_pager::setPaginationData(
                $total,
                $limit,
                $basePath,
                $this->getpage,
                '='
            );
            $pagination = null;
            if ($dataPager != null) {
                $pagination = '<ul class="pagination">';
                foreach ($dataPager as $row) {
                    switch ($row['name']){
                        case 'first':
                            $name = '<<';
                            break;
                        case 'previous':
                            $name = '<';
                            break;
                        case 'next':
                            $name = '>';
                            break;
                        case 'last':
                            $name = '>>';
                            break;
                        default:
                            $name = $row['name'];
                    }
                    $classItem = ($name == $this->getpage) ? ' class="active"' : null;
                    $pagination .= '<li'.$classItem.'>';
                    $pagination .= '<a href="'.$row['url'].'" title="'.$name.'" >';
                    $pagination .= $name;
                    $pagination .= '</a>';
                    $pagination .= '</li>';
                }
                $pagination .= '</ul>';
            }
            unset($total);
            unset($limit);
        }
        return $pagination;
    }

    /**
     * Retourne la liste des news au format JSON
     * @param $limit
     */
    private function json_list_news($limit){
        $role = new backend_model_role();
        $pager = new magixglobal_model_pager();
        $max = $limit;
        $offset= $pager->setPaginationOffset($limit,$this->getpage);
        $limit = $max;
        if(parent::s_news_list($this->getlang,$limit,$max,$offset) != null){
            foreach (parent::s_news_list($this->getlang,$limit,$max,$offset) as $key){
                if ($key['n_content'] != null){
                    $content = 1;
                }else{
                    $content = 0;
                }
                if ($key['n_image'] != null){
                    $image = 1;
                }else{
                    $image = 0;
                }
                $json[]= '{"idnews":'.json_encode($key['idnews']).',"n_image":'.json_encode($image)
                .',"n_title":'.json_encode($key['n_title']).',"n_content":'.json_encode($content)
                .',"pseudo":'.json_encode($key['pseudo_admin']).',"date_register":'.json_encode($key['date_register'])
                .',"date_publish":'.json_encode($key['date_publish']).',"published":'.json_encode($key['published'])
                .'}';
            }
            print '['.implode(',',$json).']';
        }else{
            print '{}';
        }
    }
    /**
     * @access private
     * insertion d'une nouvelle news
     */
    private function insert_news_data(){
        if(isset($this->n_title)){
            if(empty($this->n_title)){
                $this->message->getNotify('empty');
            }else{
                parent::i_news(
                    $this->extract_random_idnews(20),
                    $this->getlang,
                    $this->idadmin,
                    $this->n_title,
                    magixcjquery_url_clean::rplMagixString($this->n_title)
                );
                $this->message->getNotify('add');
            }
        }
    }
	/**
	 * @access private
	 * Le dossier images des news 
	 */
	private function dir_img_news(){
		return magixglobal_model_system::base_path().'/upload/news/';
	}

	/**
	 * @access private
	 * Insert une image dans les news
	 * @param string $nimage
	 * @param void $confimg
	 * @param bool $update
     * @return string
     * @throws Exception
	 */
	private function insert_image_news($nimage,$confimg,$update=false){
		if(isset($nimage)){
			try{
				$makeFiles = new magixcjquery_files_makefiles();
                $initImg = new backend_model_image();
				if($update == true){
					$vimage = parent::s_n_image_news($this->edit);
					if(file_exists(self::dir_img_news().$vimage['n_image'])){
						$makeFiles->removeFile(self::dir_img_news(),$vimage['n_image']);
						$makeFiles->removeFile(self::dir_img_news(),'s_'.$vimage['n_image']);
					}else{
						throw new Exception('file: '.$vimage['n_image'].' is not found');
					}
				}
				/**
				 * Envoi une image dans le dossier "racine" catalogimg
				 */
                $initImg->upload_img(
                    $confimg,
                    'upload'.DIRECTORY_SEPARATOR.'news'.DIRECTORY_SEPARATOR,
                    false
                );
				/**
				 * Analyze l'extension du fichier en traitement
				 * @var $fileextends
				 */
				$fileextends = $initImg->image_analyze(self::dir_img_news().$nimage);
				/**
				 * 
				 * Enter description here ...
				 * @var unknown_type
				 */
				$rimage = magixglobal_model_cryptrsa::uniq_id();
				/**
				 * Initialisation de la classe phpthumb 
				 * @var void
				 */
				$thumb = PhpThumbFactory::create(self::dir_img_news().$nimage);
				$imageuri = $rimage.$fileextends;
				$imgsetting = new backend_model_setting();
				$imgsizesmall = $initImg->dataImgSize('news','news','small');
				$imgsizemed = $initImg->dataImgSize('news','news','medium');
				//Redimensionnement et changement de nom suivant la catégorie
				switch($imgsizemed['img_resizing']){
					case 'basic':
						$thumb->resize($imgsizemed['width'],$imgsizemed['height'])->save(self::dir_img_news().$imageuri);
					break;
					case 'adaptive':
						$thumb->adaptiveResize($imgsizemed['width'],$imgsizemed['height'])->save(self::dir_img_news().$imageuri);
					break;
				}
				switch($imgsizesmall['img_resizing']){
					case 'basic':
						$thumb->resize($imgsizesmall['width'],$imgsizesmall['height'])->save(self::dir_img_news().'s_'.$imageuri);
					break;
					case 'adaptive':
						$thumb->adaptiveResize($imgsizesmall['width'],$imgsizesmall['height'])->save(self::dir_img_news().'s_'.$imageuri);
					break;
				}
				//Supprime le fichier original pour gagner en espace
				if(file_exists(self::dir_img_news().$nimage)){
					$makeFiles->removeFile(self::dir_img_news(),$nimage);
				}/*else{
					throw new Exception('file: '.$nimage.' is not found');
				}*/
				return $imageuri;
			}catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}

	/**
	 * @access private
	 * Chargement de l'url public courante avec JSON
	 */
	private function json_uri($data){
		if($data['idnews'] != null){
			$dateformat = new magixglobal_model_dateformat();
			$uri = magixglobal_model_rewrite::filter_news_url(
				$data['iso'], 
				$dateformat->date_europeen_format($data['date_register']), 
				$data['n_uri'], 
				$data['keynews'],
				true
			);
			$input= '{"newslink":'.json_encode(magixcjquery_url_clean::rplMagixString($uri)).'}';
			print $input;
		}
	}

	/**
	 * @access private
	 * Charge les données du formulaire pour la mise à jour
	 */
	private function load_edit_data($create,$data){
		/**
		 * Retourne un tableau des données
		 * @var 
		 */
        $create->assign('idnews',$data['idnews'],true);
		$create->assign('n_title',$data['n_title'],true);
        $create->assign('n_content',$data['n_content'],true);
        $create->assign('n_uri',$data['n_uri'],true);
        $create->assign('idlang',$data['idlang'],true);
        $create->assign('iso',$data['iso'],true);
        $create->assign('date_register',$data['date_register'],true);
        $create->assign('published',$data['published'],true);
        $create->assign('tags',$data['WORD_LIST'],true);
	}

    /**
     * @access private
     * Charge les données de l'image de la news
     * @param $create
     * @param $news_img
     */
    private function ajax_image($create,$news_img){
        if(file_exists($create->basePathConfig('section').'local_'.backend_model_language::current_Language().'.conf')){
            $create->configLoad(
                $create->basePathConfig('section').'local_'.backend_model_language::current_Language().'.conf',
                ''
            );
        }
		if($news_img != null){
            $img = '<p><img src="/upload/news/s_'.$news_img.'" class="img-thumbnail" alt="" /></p>';
            $img .= '<p><a class="btn btn-danger delete-image"><span class="icon-trash"></span> '.$create->getConfigVars("remove").'</a></p>';
		}else{
			$img = '<p><img data-src="holder.js/140x140/text:Thumbnails" class="ajax-image img-thumbnail" /></p>';
		}
		print $img;
	}

	/**
	 * @access private
	 * POST le formulaire de mise à jour des données
	 */
	private function update_news_data(){
		if(isset($this->n_title)){
			if(empty($this->n_title)){
                $this->message->getNotify('empty');
			}else{
				switch($this->published){
					case 0:
						$date_publication = '0000-00-00 00:00:00';
					break;
					case 1:
						$dateformat = new magixglobal_model_dateformat();
						$date_publication = $dateformat->SQLDateTime();
					break;
				}
				if(!empty($this->n_uri)){
					$uri = $this->n_uri;
				}else{
					$uri = magixcjquery_url_clean::rplMagixString($this->n_title);
				}
				parent::u_news_page(
					$this->n_title,
					$uri,
					$this->n_content,
					$this->idadmin,
					$date_publication,
					$this->published,
					$this->edit
				);
                $lang = new backend_db_block_lang();
                $data = $lang->s_data_iso($this->getlang);
                $rss = new backend_controller_rss();
                $rss->run('news',
                    array(
                        'idlang'=>$data['idlang'],
                        'iso'=>$data['iso']
                    )
                );
                $this->message->getNotify('update');
			}
		}
	}

	/**
	 * @access private
	 * Mise à jour d'une image d'une news
	 */
	private function update_news_image(){
		if(isset($this->n_image)){
            if($this->n_image != null){
				$img = self::insert_image_news($this->n_image,'n_image',true);
			}else{
				$makeFiles = new magixcjquery_files_makefiles();
				$vimage = parent::s_n_image_news($this->edit);
				if(file_exists(self::dir_img_news().$vimage['n_image'])){
					$makeFiles->removeFile(self::dir_img_news(),$vimage['n_image']);
					$makeFiles->removeFile(self::dir_img_news(),'s_'.$vimage['n_image']);
				}
				$img = null;
			}
			parent::u_news_image($img, $this->edit);
		}
	}

	/**
	 * @access private
	 * Modifie le status de la news
	 */
	private function update_published(){
		if(isset($this->idnews) AND isset($this->published)){
			parent::u_status_published($this->idnews,$this->published);
            $lang = new backend_db_block_lang();
            $data = $lang->s_data_iso($this->getlang);
			$rss = new backend_controller_rss();
		    $rss->run('news',
                array(
                    'idlang'=>$data['idlang'],
                    'iso'=>$data['iso']
                )
            );
		}
	}

	/**
	 * @access private
	 * Supprime une news
	 */
	private function remove_news(){
		if(isset($this->delete_news)){
			parent::d_news($this->delete_news);
		}
	}

    /**
     * Suppression d'image
     */
    private function remove_image(){
        if(isset($this->delete_image)){
            $makeFiles = new magixcjquery_files_makefiles();
            $vimage = parent::s_n_image_news($this->delete_image);
            if(file_exists(self::dir_img_news().$vimage['n_image'])){
                $makeFiles->removeFile(self::dir_img_news(),$vimage['n_image']);
                $makeFiles->removeFile(self::dir_img_news(),'s_'.$vimage['n_image']);
            }
            $img = null;
            parent::u_news_image($img, $this->delete_image);
        }
    }
    /**
     * @access private
     * Requête JSON pour les statistiques du CMS
     */
    private function json_graph(){
        if(parent::s_stats_pages() != null){
            foreach (parent::s_stats_pages() as $key){
                $stat[]= array(
                    'x'=>magixcjquery_string_convert::upTextCase($key['iso']),
                    'y'=>$key['PAGES'],
                    'z'=>$key['TAGS']
                );
            }
            print json_encode($stat);
        }
    }

	/**
	 * @access private
	 * Ajouter un tag à une news
	 */
	private function add_reltag(){
		if(isset($this->name_tag)){
			if(!empty($this->name_tag)){
				parent::i_reltag($this->name_tag,$this->edit);
			}
		}
	}

	/**
	 * @access private
	 * Suppression d'un tag d'une news
	 */
	private function remove_tag(){
		if(isset($this->delete_tag)){
			parent::d_tagnews($this->edit,$this->delete_tag);
		}
	}

	//SEARCH
    /**
	 * @access private
	 * Rechercher une news et retourne sous forme JSON
	 */
	private function json_url_news(){
		if($this->news_search != ''){
			if(parent::s_search_news($this->news_search) != null){
				foreach (parent::s_search_news($this->news_search) as $key){
					$dateformat = new magixglobal_model_dateformat();
					$url_news = magixglobal_model_rewrite::filter_news_url(
						$key['iso'],
						$dateformat->date_europeen_format($key['date_register']),
						$key['n_uri'],
						$key['keynews'],
						true
					);
					$json[]= '{"idnews":'.json_encode($key['idnews']).',"n_title":'.json_encode($key['n_title']).
					',"iso":'.json_encode(magixcjquery_string_convert::upTextCase($key['iso'])).
					',"url_news":'.json_encode($url_news).',"date_register":'.json_encode($key['date_register']).'}';
				}
				print '['.implode(',',$json).']';
			}
		}else{
            print '{}';
        }
	}
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		$header= new magixglobal_model_header();
        $create = new backend_controller_template();
        $plugin = new backend_controller_plugins();
        $create->addConfigFile(array(
                'news'
            ),array('news_'),false
        );
        $access = $this->model_access->module_access("backend_controller_news");
        $create->assign('access',$access);
        if(magixcjquery_filter_request::isGet('getlang')){
            if(isset($this->action)){
                if($this->action == 'list'){
                    $max = 20;
                    if(magixcjquery_filter_request::isGet('json_list_news')){
                        $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                        $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                        $header->pragma();
                        $header->cache_control("nocache");
                        $header->getStatus('200');
                        $header->json_header("UTF-8");
                        $this->json_list_news($max);
                    }else{
                        $create->assign('pagination',$this->news_pagination($max));
                        $create->display('news/list.tpl');
                    }
                }elseif($this->action == 'add'){
                    if(isset($this->n_title)){
                        $this->insert_news_data();
                    }
                }elseif($this->action == 'edit'){
                    if(isset($this->edit)){
                        $data = parent::s_news_data($this->edit);
                        $create->assign('plugin',$plugin->menu_item_plugin('news'));
                        if(magixcjquery_filter_request::isGet('json_urinews')){
                            $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                            $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                            $header->pragma();
                            $header->cache_control("nocache");
                            $header->getStatus('200');
                            $header->json_header("UTF-8");
                            $this->json_uri($data);
                        }elseif(magixcjquery_filter_request::isGet('ajax_image')){
                            $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                            $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                            $header->pragma();
                            $header->cache_control("nocache");
                            $header->getStatus('200');
                            $header->html_header("UTF-8");
                            $this->ajax_image($create,$data['n_image']);
                        }elseif(isset($this->n_image)){
                            $this->update_news_image();
                        }elseif(isset($this->n_title)){
                            $this->update_news_data();
                        }elseif(isset($this->name_tag)){
                            $this->add_reltag();
                        }elseif(isset($this->delete_tag)){
                            $this->remove_tag();
                        }else{
                            if(isset($this->plugin)){
                                // Chargement du plugin dans les actualités (edition)
                                $this->load_edit_data($create,$data);
                                $param_arr = array($this->plugin,$this->getlang,$this->edit);
                                $plugin->extend_module($this->plugin,'news',$param_arr);
                            }else{
                                $this->load_edit_data($create,$data);
                                $create->display('news/edit.tpl');
                            }
                        }
                    }else{
                        if(isset($this->published)){
                            $this->update_published();
                        }
                    }
                }elseif($this->action == 'remove'){
                    if(isset($this->delete_news)){
                        $this->remove_news();
                    }elseif(isset($this->delete_image)){
                        $this->remove_image();
                    }
                }
            }
        }else{
            if(magixcjquery_filter_request::isGet('json_graph')){
                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                $header->pragma();
                $header->cache_control("nocache");
                $header->getStatus('200');
                $header->json_header("UTF-8");
                $this->json_graph();
            }elseif(isset($this->news_search)){
                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                $header->pragma();
                $header->cache_control("nocache");
                $header->getStatus('200');
                $header->json_header("UTF-8");
                $this->json_url_news();
            }else{
                $create->display('news/index.tpl');
            }
        }
	}
}