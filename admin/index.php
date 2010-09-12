<?php
/**
 * MAGIX CMS
 * @category   admin
 * @package    Exec Files
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name index
 *
 */
/**
 * Charge toutes les Classes de l'application
 */
$adminpathdir = dirname(realpath( __FILE__ ));
$adminarraydir = array('admin');
$adminpath = str_replace($adminarraydir,array('') , $adminpathdir);
$loaderFilename = $adminpath.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'loaderIniclass.php';
if (!file_exists($loaderFilename)) {
	print "<p>Loader is not found<br />Contact Support Magix CMS: support@cms-site.com</p>";
	exit;
}else{
	require $loaderFilename;
}
require(magixglobal_model_system::base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'autoload.php');
$config = magixglobal_model_system::base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
if (!file_exists($config)) {
	//Header("Location: /install/index.php");
	print '<p>La base de donnée n\'existe pas, veuillez suivre la procédure pour faire l\'<a href="/install/">installation</a> de Magix CMS</p>';
	exit;
}
/**
 * Autoload Frontend
 */
backend_Autoloader::register();
$members = new backend_controller_admin();
$members->securePage();
$members->closeSession();
if(magixcjquery_filter_request::isSession('useradmin')){
	if(magixcjquery_filter_request::isGet('dashboard')){
		backend_controller_config::load_attribute_config();
		/*if(magixcjquery_filter_request::isGet('home')){
			$home = new backend_controller_home();
			if(magixcjquery_filter_request::isGet('edit')){
				if(magixcjquery_filter_request::isGet('post')){
					$home->update_data_forms();
				}else{
					$home->edit();
				}
			}elseif(magixcjquery_filter_request::isGet('add')){
				$home->insert_data_forms();
			}elseif(magixcjquery_filter_request::isGet('delhome')){
				$home->del_home();
			}else{
				$home->display();
			}
		}else*/if(magixcjquery_filter_request::isGet('config')){
			$config = new backend_controller_config();
			if(magixcjquery_filter_request::isGet('metasrewrite')){
				if(magixcjquery_filter_request::isGet('edit')){
					$config->display_seo_edit();
				}elseif(magixcjquery_filter_request::isGet('drmetas')){
					$config->d_rewrite();
				}else{
					$config->display_seo();
				}
			}else{
				$config->display();
			}
		}elseif(magixcjquery_filter_request::isGet('user')){
			$user = new backend_controller_user();
			if(magixcjquery_filter_request::isGet('post')){
				$user->post();
			}elseif(magixcjquery_filter_request::isGet('deluser')){
				$user->delete_user();
			}elseif(magixcjquery_filter_request::isGet('edit')){
				$user->display_edit();
			}else{
				$user->display();
			}
		}elseif(magixcjquery_filter_request::isGet('lang')){
			$ini = new backend_controller_lang();
			if(magixcjquery_filter_request::isGet('edit')){
				$ini->edit();
			}if(magixcjquery_filter_request::isGet('dellang')){
				$ini->delete_lang_record();
			}else{
				$ini->display();
			}
		}elseif(magixcjquery_filter_request::isGet('news')){
			$news = new backend_controller_news();
			if(magixcjquery_filter_request::isGet('edit')){
				$news->edit();
			}elseif(magixcjquery_filter_request::isGet('add')){
				$news->display_addnews();
			}elseif(magixcjquery_filter_request::isGet('delnews')){
				$news->del_news();
			}else{
				$news->display_news();
			}
		}/*elseif(magixcjquery_filter_request::isGet('cms')){
			$ini = new backend_controller_cms();
			if(magixcjquery_filter_request::isGet('add')){
				if(magixcjquery_filter_request::isGet('post')){
					$ini->insert_new_page();
				}else{
					$ini->display_page();
				}
			}elseif(magixcjquery_filter_request::isGet('editcms')){
				if(magixcjquery_filter_request::isGet('post')){
					$ini->update_page();
				}else{
					$ini->display_edit_page();
				}
			}elseif(magixcjquery_filter_request::isGet('navigation')){
				$ini->display_navigation();
			}elseif(magixcjquery_filter_request::isGet('delpage')){
				$ini->delete_page_cms();
			}elseif(magixcjquery_filter_request::isGet('orderajax')){
				$ini->executeOrderCategory();
				$ini->executeOrderPage();
			}elseif(magixcjquery_filter_request::isGet('category')){
				if(magixcjquery_filter_request::isGet('post')){
					$ini->insertion_category();
				}else{
					$ini->display_category();
				}
			}elseif(magixcjquery_filter_request::isGet('ucategory')){
				if(magixcjquery_filter_request::isGet('post')){
					$ini->update_category_cms();
				}else{
					$ini->edit_category_cms();
				}
			}elseif(magixcjquery_filter_request::isGet('dcmscat')){
				$ini->delete_category_cms();
			}
			else{
				$ini->display_view();
			}
		}*/elseif(magixcjquery_filter_request::isGet('catalog')){
			$catalog = new backend_controller_catalog();
			if(magixcjquery_filter_request::isGet('category')){
				if(magixcjquery_filter_request::isGet('delc')){
					$catalog->delete_catalog_category();
				}elseif(magixcjquery_filter_request::isGet('dels')){
					$catalog->delete_catalog_subcategory();
				}elseif(magixcjquery_filter_request::isGet('post')){
					$catalog->post_category();
				}else{
					$catalog->display_category();
				}
			}elseif(magixcjquery_filter_request::isGet('upcat')){
				if(magixcjquery_filter_request::isGet('post')){
					$catalog->update_category();
				}else{
					$catalog->display_edit_category();
				}
			}elseif(magixcjquery_filter_request::isGet('upsubcat')){
				if(magixcjquery_filter_request::isGet('post')){
					$catalog->update_subcategory();
				}else{
					$catalog->display_edit_subcategory();
				}
			}elseif(magixcjquery_filter_request::isGet('product')){
				if(magixcjquery_filter_request::isGet('addproduct')){
					$catalog->insert_new_product();
				}elseif(magixcjquery_filter_request::isGet('editproduct')){
					if(magixcjquery_filter_request::isGet('updateproduct')){
						$catalog->update_specific_product();
					}else{
						$catalog->display_edit_product();
					}
				}elseif(magixcjquery_filter_request::isGet('moveproduct')){
					if(magixcjquery_filter_request::isGet('postmoveproduct')){
						$catalog->move_specific_product();
					}else{
						$catalog->display_move_product();
					}
				}elseif(magixcjquery_filter_request::isGet('copyproduct')){
					if(magixcjquery_filter_request::isGet('postcopyproduct')){
						$catalog->copy_product();
					}else{
						$catalog->display_copy_product();
					}
				}elseif(magixcjquery_filter_request::isGet('getimg')){
					if(magixcjquery_filter_request::isGet('postimgproduct')){
						$catalog->insert_image_product();
					}elseif(magixcjquery_filter_request::isGet('postimggalery')){
						$catalog->insert_image_galery();
					}elseif(magixcjquery_filter_request::isGet('delmicro')){
						$catalog->delete_image_microgalery();
					}else{
						$catalog->display_product_image();
					}
				}elseif(magixcjquery_filter_request::isGet('delproduct')){
					$catalog->delete_catalog_product();
				}else{
					$catalog->display_product();
				}
			}elseif(magixcjquery_filter_request::isGet('order')){
				$catalog->executeOrderCategory();
				$catalog->executeOrderSubCategory();
			}elseif(magixcjquery_filter_request::isGet('json')){
				$catalog->get_select_json_construct();
			}else{
				$catalog->display();
			}
		}elseif(magixcjquery_filter_request::isGet('forms')){
			$ini = new backend_controller_formsconstruct();
			if(magixcjquery_filter_request::isGet('addforms')){
				
			}elseif(magixcjquery_filter_request::isGet('editforms')){
				
			}elseif(magixcjquery_filter_request::isGet('getforms')){
				$ini->display_forms_input();
			}elseif(magixcjquery_filter_request::isGet('delinput')){
				$ini->delete_input();
			}
			else{
				$ini->display_index();
			}
		}/*elseif(magixcjquery_filter_request::isGet('templates')){
			$tpl = new backend_controller_templates();
			if(magixcjquery_filter_request::isGet('post')){
				$tpl->send_post_template();
			}else{
				$tpl->view_tpl_screen();
			}
		}*/elseif(magixcjquery_filter_request::isGet('plugin')){
			$plugin = new backend_controller_plugins();
			$plugin->display_plugins();
		}elseif(magixcjquery_filter_request::isGet('googletools')){
			$googletools = new backend_controller_googletools();
			if(magixcjquery_filter_request::isGet('pgdata')){
				$googletools->post_gdata();
			}else{
				$googletools->display_gdata();
			}
		}elseif(magixcjquery_filter_request::isGet('sitemap')){
			$sitemap = new backend_controller_sitemap();
			if(magixcjquery_filter_request::isGet('createxml')){
				$sitemap->exec();
			}elseif(magixcjquery_filter_request::isGet('googleping')){
				$sitemap->execPing();
			}elseif(magixcjquery_filter_request::isGet('compressionping')){
				$sitemap->execCompressionPing();
			}else{
				$sitemap->display();
			}
		}else{
			$ini = new backend_controller_dashboard();
			$ini->display();
		}
	}else{
		if (!headers_sent()) {
			header('location: '.magixcjquery_html_helpersHtml::getUrl().'/admin/index.php?dashboard');
			exit();
		}
	}
}
?>