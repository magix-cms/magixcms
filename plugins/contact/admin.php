<?php
/**
 * @category   Plugins 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2010 - 2011 (http://www.logiciel-referencement-professionnel.com/)
 * @license    Proprietary software
 * @version    1.0 03-06-2010
 * Update      1.1 11-06-2010
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 * @name contact
 * @version 0.2
 *
 */
class plugins_contact_admin{
/**
	 * Fonction pour la création des urls dans le sitemap
	 * !!! createSitemap obligatoire pour l'ajout dans le sitemap
	 */
	public function createSitemap(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
		   $sitemap->writeMakeNode(
				magixcjquery_html_helpersHtml::getUrl().'/magixmod/contact/',
				date('d-m-Y'),
				'always',
				0.7
		   );
	}
}