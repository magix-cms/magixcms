[magixcms](http://www.magix-cms.com/)
===================================================

![Logo Magix CMS](http://www.magix-cms.com/skin/magixcms/img/logo-magix_cms.png "Logo Magix CMS")

Presentation
------------

Magix cms est un gestionnaire de contenu développé en PHP 5,
proposant une multitude d'outils intégrés.
Le gestionnaire est simple et intuitif permettant une adaptation rapide pour tout utilisateur,
ainsi qu'une indexation optimal dans les moteurs de recherches.

## Note
    N'utilisez pas la version de ce dépôt pour autre chose que vos propres tests,
    la dernière version stable sur le site est optimisé pour la mise en production.


Authors
-------

 * Gerits Aurelien (Author-Developer) contact[at]aurelien-gerits[point]be - aurelien[at]magix-cms[point]com
    * [magixcms](http://www.magix-cms.com)
    * [CV Aurelien Gerits](http://www.aurelien-gerits.be)
    * [Github Aurelien Gerits](https://github.com/gtraxx/)
    * [MagixcjQuery](http://www.magix-cjquery.com)

## Contributors

 * Lesire Samuel (http://www.sire-sam.be)
 * Jean-Baptiste Demonte (http://jb.demonte.fr)
 * Salvatore (http://www.disalvo-infographiste.be)
 
Site officiel
-----

 * http://www.magix-cms.com (site officiel)
 * http://www.magix-cms.com/fr/catalogue/ (Documentation intégrateur)

Ressources
-----
 * https://github.com/Xarksass/CenterColumns
 * https://github.com/gtraxx/tinymce-plugin-youtube
 * https://github.com/gtraxx/tinymce-plugin-codehighlight
 * https://github.com/gtraxx/jimagine
 * https://github.com/trippo/ResponsiveFilemanager
 * http://www.tinymce.com/
 * http://getbootstrap.com/
 * http://www.smarty.net
 * http://magix-cjquery.com/

Plugins
-----
 * [Faq](https://github.com/magix-cms/faq)
 * [Advantage](https://github.com/magix-cms/advantage)
 * [Gmap](https://github.com/gtraxx/gmap)
 * [Mailchimp](https://github.com/magix-cms/mailchimp)

Requirements
------------

### Server
 * APACHE / IIS / NGINX
     * Le serveur doit avoir la réécriture d'url activé pour fonctionné (rewrite_mod).
 * PHP 5.2 et plus
     * GD activé
     * SPL
     * SimpleXML et XML READER
     * PDO
 * MYSQL
#### Note: Pour utiliser Magix CMS avec PHP 5.3
<pre>
error_reporting = E_ALL & ~E_NOTICE & ~E_DEPRECATED
</pre>
#### Note: Pour utiliser Magix CMS avec PHP 5.4
<pre>
error_reporting = E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT
</pre>

#### Remove bug minify with Bootstrap and Less (apache)
```apache
    <IfModule mpm_winnt_module>
       ThreadStackSize 8388608
    </IfModule>
```
### Required Library

    Smarty 3 (http://www.smarty.net/download)
    copy to: /lib/smarty3

    Magixcjquery (http://sourceforge.net/projects/magixcjquery/files/magixcjquery-stable/3.x/)
    copy to: /lib/magixcjquery

Il faut ajouté le dossier smarty3 et magixcjquery dans le dossier lib,
vous pouvez télécharger les dernières versions pour être compatible avec magix cms.

### Required Application

Pour modifier un template, installez NODE.JS et LESS

 * https://nodejs.org
 * http://lesscss.org


Licence
------------

<pre>
This file is part of Magix CMS.
MAGIX CMS, The content management system optimized for users

Copyright (C) 2008 - 2016 magix-cms.com support[at]magix-cms[point]com

OFFICIAL TEAM :

-  Gerits Aurelien (Author - Developer) contact[at]aurelien-gerits[point]be - aurelien[at]magix-cms[point]com

Redistributions of files must retain the above copyright notice.
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

####DISCLAIMER

Do not edit or add to this file if you wish to upgrade magixcms to newer
versions in the future. If you wish to customize magixcms for your
needs please refer to magix-cms.com for more information.
</pre>

##Synchronize your fork
    
    #cd your_fork
    cd magixcms

    #git remote add your_fork git@github.com:gtraxx/magixcms.git
    git remote add magixcms git@github.com:gtraxx/magixcms.git
    git fetch magixcms

    #Merge your local copy with the original project
    git checkout master
    git merge magixcms/master

    #Commit your changes
    git commit -a -m "Synchronization with the original project"

    #Send your changes to github
    git push
