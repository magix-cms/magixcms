<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2016 magix-cms.com <support@magix-cms.com>
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
class frontend_controller_webservice extends frontend_db_webservice{
    protected $outputxml,$message;
    public $collection,$retrieve,$id,$action,$img,$debug;
    public static $notify = array('plugin' => 'false', 'method' => 'print', 'template'=> '');

    /**
     * frontend_controller_webservice constructor.
     */
    public function __construct(){
        $this->webservice = new frontend_model_webservice();
        $this->outputxml = new magixglobal_model_outputxml();
        $this->dbCatalog = new frontend_db_catalog();
        $this->Catalog = new frontend_model_catalog();
        $this->url = magixcjquery_html_helpersHtml::getUrl();
        $this->ModelImagePath     =   new magixglobal_model_imagepath();
        if (class_exists('frontend_model_message')) {
            $this->message = new frontend_model_message();
        }
        // GET
        if(magixcjquery_filter_request::isGet('collection')){
            $this->collection = magixcjquery_form_helpersforms::inputClean($_GET['collection']);
        }
        if(magixcjquery_filter_request::isGet('retrieve')){
            $this->retrieve = magixcjquery_form_helpersforms::inputClean($_GET['retrieve']);
        }
        if(magixcjquery_filter_request::isGet('id')){
            $this->id = magixcjquery_form_helpersforms::inputNumeric($_GET['id']);
        }
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('debug')){
            $this->debug = magixcjquery_form_helpersforms::inputClean($_GET['debug']);
        }
        // POST
        if(isset($_FILES['img']["name"])){
            $this->img = magixcjquery_url_clean::rplMagixString($_FILES['img']["name"]);
        }
    }


    // ############## GET
    /**
     * Global Root
     */
    private function getRoot(){
        $data = array('catalog');
        $this->outputxml->newStartElement('modules');
        foreach($data as $key) {
            $this->outputxml->setElement(
                array(
                    'start' => 'module',
                    'attrNS' => array(
                        array(
                            'prefix' => 'xlink',
                            'name' => 'href',
                            'uri' => $this->url . '/webservice/'.$key.'/'
                        )
                    )
                )
            );
        }
        $this->outputxml->newEndElement();
        $this->outputxml->output();
    }

    //######################## Catalog ####################
    /**
     * Root catalog
     */
    private function getCatalogRoot(){
        $data = array('categories','subcategories','products');
        $this->outputxml->newStartElement('catalog');
        foreach($data as $key) {
            $this->outputxml->setElement(
                array(
                    'start' => 'api',
                    'attrNS' => array(
                        array(
                            'prefix' => 'xlink',
                            'name' => 'href',
                            'uri' => $this->url . '/webservice/catalog/'.$key.'/'
                        )
                    )
                )
            );
        }
        $this->outputxml->newEndElement();
        $this->outputxml->output();
    }
    /**
     * get catalog categories
     */
    private function getCatalogCategories(){
        $data = $this->dbCatalog->fetchCategory(
            array(
                'fetch'  =>  'all'
            )
        );
        $this->outputxml->newStartElement('categories');
        foreach($data as $key){
            $this->outputxml->setElement(
                array(
                    'start'=>'category',
                    'attr'=>array(
                        array(
                            'name'      =>  'id',
                            'content'   =>  $key['idclc']
                        ),
                        array(
                            'name'      =>  'name',
                            'content'   =>  $key['clibelle']
                        ),
                        array(
                            'name'      =>  'idlang',
                            'content'   =>  $key['idlang']
                        )
                    ),
                    'attrNS'=>array(
                        array(
                            'prefix'    =>  'xlink',
                            'name'      =>  'href',
                            'uri'       =>  $this->url.'/webservice/catalog/categories/'.$key['idclc'].'/'
                        )
                    )
                )
            );
        }

        $this->outputxml->newEndElement();
        $this->outputxml->output();
    }

    /**
     * get catalog categories id
     * @param $id
     */
    private function getCatalogCategory($id){

        $data = $this->dbCatalog->s_category_data($id);

        $dataClean = $this->Catalog->setItemData($data, 0);
        // query for sub category
        $fetchSubcategory = $this->Catalog->fetchSubCategory(
            array(
                'fetch' => 'in_cat',
                'idclc' => $id
            )
        );
        // query for product
        $fetchProduct = $this->Catalog->fetchProduct(
            array(
                'fetch'         =>  'all_in',
                'idclc'         =>  $id,
                'idcls'         =>  0
            )
        );

        $this->outputxml->newStartElement('category');
        $this->outputxml->setElement(
            array(
                'start' => 'language',
                'attr' => array(
                    array(
                        'name' => 'id',
                        'content' => $dataClean['idlang']
                    )
                )
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'id_parent',
                'text' => '0'
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'id',
                'text' => $id
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'name',
                'text' => $dataClean['name']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'url',
                'text' => $dataClean['baseUrl']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'description',
                'cData' => $dataClean['content']
            )
        );
        // Start image category
        $this->outputxml->newStartElement('images');
            if($dataClean['imgSrc']['large'] != null){
                $this->outputxml->setElement(
                    array(
                        'start' => 'image',
                        'attrNS' => array(
                            array(
                                'prefix' => 'xlink',
                                'name' => 'href',
                                'uri' => $this->url . $dataClean['imgSrc']['large']
                            )
                        )
                    )
                );
            }

        $this->outputxml->newEndElement();
        // End image category
        $this->outputxml->setElement(
            array(
                'start' => 'order',
                'text' => $dataClean['order']
            )
        );
        // Start sub categories links
        // Load Subcategories in category
        $this->outputxml->newStartElement('subcategories');
            if($fetchSubcategory != null) {
                foreach ($fetchSubcategory as $key) {
                    $this->outputxml->setElement(
                        array(
                            'start' => 'subcategory',
                            'attr'=>array(
                                array(
                                    'name'      =>  'id',
                                    'content'   =>  $key['idcls']
                                ),
                                array(
                                    'name'      =>  'name',
                                    'content'   =>  $key['slibelle']
                                )
                            ),
                            'attrNS' => array(
                                array(
                                    'prefix' => 'xlink',
                                    'name' => 'href',
                                    'uri' => $this->url . '/webservice/catalog/subcategories/' . $key['idcls'].'/'
                                )
                            )
                        )
                    );
                }
            }
        $this->outputxml->newEndElement();
        // End sub categories links

        // Start products links
        $this->outputxml->newStartElement('products');
        // Load products in category
        if($fetchProduct != null) {
            foreach ($fetchProduct as $key) {
                $this->outputxml->setElement(
                    array(
                        'start' => 'product',
                        'attr'=>array(
                            array(
                                'name'      =>  'id',
                                'content'   =>  $key['idcatalog']
                            ),
                            array(
                                'name'      =>  'name',
                                'content'   =>  $key['titlecatalog']
                            ),
                            array(
                                'name'      =>  'price',
                                'content'   =>  $key['price']
                            )
                        ),
                        'attrNS' => array(
                            array(
                                'prefix' => 'xlink',
                                'name' => 'href',
                                'uri' => $this->url . '/webservice/catalog/products/' . $key['idcatalog'].'/'
                            )
                        )
                    )
                );
            }
        }
        $this->outputxml->newEndElement();
        // End products links
        $this->outputxml->newEndElement();
        $this->outputxml->output();
    }

    /**
     * get catalog subcategories id
     * @param $id
     */
    private function getCatalogSubCategories($id)
    {

        $data = $this->dbCatalog->s_subcategory_data($id);
        $dataClean = $this->Catalog->setItemData($data, 0);

        // query for product
        $fetchProduct = $this->Catalog->fetchProduct(
            array(
                'fetch'         =>  'all_in',
                'idclc'         =>  $dataClean['idparent'],
                'idcls'         =>  $id
            )
        );

        $this->outputxml->newStartElement('subcategory');
        $this->outputxml->setElement(
            array(
                'start' => 'id_parent',
                'text' => $dataClean['idparent']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'id',
                'text' => $id
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'name',
                'text' => $dataClean['name']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'url',
                'text' => $dataClean['baseUrl']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'description',
                'cData' => $dataClean['content']
            )
        );
        // Start Image subcategory
        $this->outputxml->newStartElement('images');
            if($dataClean['imgSrc']['large'] != null){
                $this->outputxml->setElement(
                    array(
                        'start' => 'image',
                        'attrNS' => array(
                            array(
                                'prefix' => 'xlink',
                                'name' => 'href',
                                'uri' => $this->url . $dataClean['imgSrc']['large']
                            )
                        )
                    )
                );
            }
        $this->outputxml->newEndElement();
        // End Image subcategory
        $this->outputxml->setElement(
            array(
                'start' => 'order',
                'text' => $dataClean['order']
            )
        );
        // Start products links
        $this->outputxml->newStartElement('products');
            // Load products in subcategory
            if($fetchProduct != null) {
                foreach ($fetchProduct as $key) {
                    $this->outputxml->setElement(
                        array(
                            'start' => 'product',
                            'attr'=>array(
                                array(
                                    'name'      =>  'id',
                                    'content'   =>  $key['idcatalog']
                                ),
                                array(
                                    'name'      =>  'name',
                                    'content'   =>  $key['titlecatalog']
                                ),
                                array(
                                    'name'      =>  'price',
                                    'content'   =>  $key['price']
                                )
                            ),
                            'attrNS' => array(
                                array(
                                    'prefix' => 'xlink',
                                    'name' => 'href',
                                    'uri' => $this->url . '/webservice/catalog/products/' . $key['idcatalog'].'/'
                                )
                            )
                        )
                    );
                }
            }
        $this->outputxml->newEndElement();
        // end products links

        $this->outputxml->newEndElement();
        $this->outputxml->newEndElement();
        $this->outputxml->output();
    }
    // ###### PRODUCT ######
    /**
     * get catalog products
     */
    private function getCatalogProducts(){
        $data = parent::fetchCatalog(
            array(
                'retrieve' => 'products',
                'context'  => 'product',
                'fetch'    =>  'all'
            )
        );
        $this->outputxml->newStartElement('products');
        foreach($data as $key){
            $this->outputxml->setElement(
                array(
                    'start'=>'product',
                    'attr'=>array(
                        array(
                            'name'      =>  'id',
                            'content'   =>  $key['idcatalog']
                        ),
                        array(
                            'name'      =>  'idlang',
                            'content'   =>  $key['idlang']
                        ),
                        array(
                            'name'      =>  'price',
                            'content'   =>  $key['price']
                        )
                    ),
                    'attrNS'=>array(
                        array(
                            'prefix'    =>  'xlink',
                            'name'      =>  'href',
                            'uri'       =>  $this->url.'/webservice/catalog/products/'.$key['idcatalog'].'/'
                        )
                    )
                )
            );
        }

        $this->outputxml->newEndElement();
        $this->outputxml->output();
    }

    /**
     * @param $id
     */
    private function getCatalogProduct($id){

        $data = parent::fetchCatalog(
            array(
                'retrieve'  =>'products',
                'context'   => 'product',
                'fetch'     =>  'one',
                'id'        =>  $id
            )
        );

        $dataClean = $this->Catalog->setItemData($data, 0);

        $this->outputxml->newStartElement('product');
        $this->outputxml->setElement(
            array(
                'start' => 'language',
                'attr' => array(
                    array(
                        'name' => 'id',
                        'content' => $dataClean['idlang']
                    )
                )
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'id',
                'text' => $id
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'name',
                'text' => $dataClean['name']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'url',
                'text' => $dataClean['baseUrl']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'price',
                'text' => $dataClean['price']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'description',
                'cData' => $dataClean['content']
            )
        );
        // Start Image product
        $this->outputxml->newStartElement('images');
        if($dataClean['imgSrc']['large'] != null){
            $this->outputxml->setElement(
                array(
                    'start' => 'image',
                    'attrNS' => array(
                        array(
                            'prefix' => 'xlink',
                            'name' => 'href',
                            'uri' => $this->url . $dataClean['imgSrc']['large']
                        )
                    )
                )
            );
        }
        $this->outputxml->newEndElement();
        // End Image product

        // Start categories links
        // Load categories in product
        $this->outputxml->newStartElement('categories');
        $fetchcategory = parent::fetchCatalog(
            array(
                'retrieve'  =>'products',
                'context'   =>  'category',
                'id'        =>  $id
            )
        );
        if($fetchcategory != null) {
            foreach ($fetchcategory as $key) {
                $this->outputxml->setElement(
                    array(
                        'start' => 'category',
                        'attr'=>array(
                            array(
                                'name'      =>  'id',
                                'content'   =>  $key['idclc']
                            ),
                            array(
                                'name'      =>  'name',
                                'content'   =>  $key['clibelle']
                            )
                        ),
                        'attrNS' => array(
                            array(
                                'prefix' => 'xlink',
                                'name' => 'href',
                                'uri' => $this->url . '/webservice/catalog/categories/' . $key['idclc'].'/'
                            )
                        )
                    )
                );
            }
        }
        $this->outputxml->newEndElement();
        // End categories links

        // Start subcategories links
        // Load subcategories in product
        $this->outputxml->newStartElement('subcategories');
        $fetchcategory = parent::fetchCatalog(
            array(
                'retrieve'  =>  'products',
                'context'   =>  'subcategory',
                'id'        =>  $id
            )
        );
        if($fetchcategory != null) {
            foreach ($fetchcategory as $key) {
                $this->outputxml->setElement(
                    array(
                        'start' => 'subcategory',
                        'attr'=>array(
                            array(
                                'name'      =>  'id',
                                'content'   =>  $key['idcls']
                            ),
                            array(
                                'name'      =>  'name',
                                'content'   =>  $key['slibelle']
                            )
                        ),
                        'attrNS' => array(
                            array(
                                'prefix' => 'xlink',
                                'name' => 'href',
                                'uri' => $this->url . '/webservice/catalog/subcategories/' . $key['idcls'].'/'
                            )
                        )
                    )
                );
            }
        }
        $this->outputxml->newEndElement();
        // End subcategories links
        // Start subcategories links

        // Load related product in product
        $this->outputxml->newStartElement('products');
        $fetchRelated = parent::fetchCatalog(
            array(
                'retrieve'  =>  'products',
                'context'   =>  'related',
                'id'        =>  $id
            )
        );
        if($fetchRelated != null) {
            foreach ($fetchRelated as $key) {
                $this->outputxml->setElement(
                    array(
                        'start' => 'related',
                        'attr'=>array(
                            array(
                                'name'      =>  'rel',
                                'content'   =>  $key['idrelproduct']
                            ),
                            array(
                                'name'      =>  'id',
                                'content'   =>  $key['idcatalog']
                            ),
                            array(
                                'name'      =>  'name',
                                'content'   =>  $key['titlecatalog']
                            )
                        ),
                        'attrNS' => array(
                            array(
                                'prefix' => 'xlink',
                                'name' => 'href',
                                'uri' => $this->url . '/webservice/catalog/products/' . $key['idcatalog'].'/'
                            )
                        )
                    )
                );
            }
        }
        $this->outputxml->newEndElement();
        // End related product links

        // Start Image gallery
        $this->outputxml->newStartElement('gallery');
        $fetchGallery = parent::fetchCatalog(
            array(
                'retrieve'  =>'products',
                'context'   =>  'gallery',
                'fetch'     =>  'all',
                'id'        =>  $id
            )
        );

        if($fetchGallery != null) {
            foreach ($fetchGallery as $key) {
                if ($key['idmicro'] != null) {
                    $this->outputxml->setElement(
                        array(
                            'start' => 'image',
                            'attrNS' => array(
                                array(
                                    'prefix' => 'xlink',
                                    'name' => 'href',
                                    'uri' => $this->url . $this->ModelImagePath->filterPathImg(
                                            array(
                                                'filtermod'=>'catalog',
                                                'img'=>'maxi/'.
                                                    $key['imgcatalog'],
                                                'levelmod'=>'galery'
                                            )
                                        )
                                )
                            )
                        )
                    );
                }
            }
        }
        $this->outputxml->newEndElement();
        // End Image gallery

        $this->outputxml->newEndElement();
        $this->outputxml->newEndElement();
        $this->outputxml->output();
    }
    //########## REQUEST POST, PUT, DELETE

    /**
     * @param bool $debug
     * @return mixed|SimpleXMLElement
     */
    public function getResult($debug = false){
        return $this->webservice->getResultParse($debug);
    }


    /**
     * Set parse data from XML OR JSON
     * @param $operations
     * @return array
     * @throws Exception
     */
    private function setParse($operations){
        try {
            switch ($operations['type']) {
                case 'catalog':
                    if ($operations['retrieve'] === 'categories') {
                        if ($operations['context'] === 'category') {
                            if ($operations['scrud'] === 'create') {
                                $language = parent::fetchLanguage(array('fetch' => 'one', 'iso' => $this->getResult()->{'category'}->{'iso'}));
                                $url = magixcjquery_url_clean::rplMagixString(
                                    $this->getResult()->{'category'}->{'name'},
                                    array('dot' => false, 'ampersand' => 'strict', 'cspec' => '', 'rspec' => '')
                                );
                                $parse = array(
                                    'idlang' => $language['idlang'],
                                    'name' => $this->getResult()->{'category'}->{'name'},
                                    'url' => $url,
                                    'content' => $this->getResult()->{'category'}->{'description'}
                                );
                            } elseif ($operations['scrud'] === 'update') {
                                if ($this->getResult()->{'category'}->{'url'} != '') {
                                    $url = $this->getResult()->{'category'}->{'url'};
                                } else {
                                    $url = magixcjquery_url_clean::rplMagixString(
                                        $this->getResult()->{'category'}->{'name'},
                                        array('dot' => false, 'ampersand' => 'strict', 'cspec' => '', 'rspec' => '')
                                    );
                                }
                                $parse = array(
                                    'id' => $this->getResult()->{'category'}->{'id'},
                                    'name' => $this->getResult()->{'category'}->{'name'},
                                    'url' => $url,
                                    'content' => $this->getResult()->{'category'}->{'description'}
                                );
                            } elseif ($operations['scrud'] === 'delete') {
                                $parse = array(
                                    'id' => $this->getResult()->{'category'}->{'id'}
                                );
                            }
                        } elseif ($operations['context'] === 'subcategory') {
                            if ($operations['scrud'] === 'create') {
                                $parse = array(
                                    'name' => $this->getResult()->{$operations['context']}->{'name'},
                                    'idparent' => $this->getResult()->{$operations['context']}->{'idparent'},
                                    'url' => magixcjquery_url_clean::rplMagixString(
                                        $this->getResult()->{$operations['context']}->{'name'},
                                        array('dot' => false, 'ampersand' => 'strict', 'cspec' => '', 'rspec' => '')
                                    ),
                                    'content' => $this->getResult()->{$operations['context']}->{'description'}
                                );
                            }
                        } elseif ($operations['context'] === 'product') {
                            if ($operations['scrud'] === 'create') {
                                $parse = array(
                                    'product'       => $this->getResult()->{$operations['context']}->{'id'},
                                    'category'      => $this->getResult()->{$operations['context']}->{'category'},
                                    'subcategory'   => $this->getResult()->{$operations['context']}->{'subcategory'}
                                );
                            }elseif ($operations['scrud'] === 'delete') {
                                $parse = array(
                                    'id'        => $this->getResult()->{$operations['context']}->{'id'}
                                );
                            }
                        }
                    } elseif ($operations['retrieve'] === 'subcategories') {
                        if ($operations['context'] === 'subcategory') {
                            if ($operations['scrud'] === 'update') {
                                if ($this->getResult()->{'subcategory'}->{'url'} != '') {
                                    $url = $this->getResult()->{'subcategory'}->{'url'};
                                } else {
                                    $url = magixcjquery_url_clean::rplMagixString(
                                        $this->getResult()->{'subcategory'}->{'name'},
                                        array('dot' => false, 'ampersand' => 'strict', 'cspec' => '', 'rspec' => '')
                                    );
                                }
                                $parse = array(
                                    'id' => $this->getResult()->{'subcategory'}->{'id'},
                                    'name' => $this->getResult()->{'subcategory'}->{'name'},
                                    'url' => $url,
                                    'content' => $this->getResult()->{'subcategory'}->{'description'}
                                );
                            }elseif ($operations['scrud'] === 'delete') {
                                $parse = array(
                                    'id' => $this->getResult()->{$operations['context']}->{'id'}
                                );
                            }
                        } elseif ($operations['context'] === 'product') {
                            if($operations['scrud'] === 'create') {
                                $parse = array(
                                    'product'       => $this->getResult()->{$operations['context']}->{'id'},
                                    'category'      => $this->getResult()->{$operations['context']}->{'category'},
                                    'subcategory'   => $this->getResult()->{$operations['context']}->{'subcategory'}
                                );
                            }elseif ($operations['scrud'] === 'delete') {
                                $parse = array(
                                    'id'  => $this->getResult()->{$operations['context']}->{'id'}
                                );
                            }
                        }
                    }elseif ($operations['retrieve'] === 'products') {
                        if ($operations['context'] === 'product') {
                            if ($operations['scrud'] === 'create') {
                                $language = parent::fetchLanguage(array('fetch' => 'one', 'iso' => $this->getResult()->{'product'}->{'iso'}));
                                $url = magixcjquery_url_clean::rplMagixString(
                                    $this->getResult()->{'product'}->{'name'},
                                    array('dot' => false, 'ampersand' => 'strict', 'cspec' => '', 'rspec' => '')
                                );
                                if($this->getResult()->{'product'}->{'price'} != ''){
                                    $price = number_format(floatval($this->getResult()->{'product'}->{'price'}), 2, '.', '');
                                }else{
                                    $price = null;
                                }

                                $parse = array(
                                    'idlang' => $language['idlang'],
                                    'name' => $this->getResult()->{'product'}->{'name'},
                                    'url' => $url,
                                    'price' => $price,
                                    'content' => $this->getResult()->{'product'}->{'description'}
                                );
                            }elseif ($operations['scrud'] === 'update') {
                                if ($this->getResult()->{'product'}->{'url'} != '') {
                                    $url = $this->getResult()->{'product'}->{'url'};
                                } else {
                                    $url = magixcjquery_url_clean::rplMagixString(
                                        $this->getResult()->{'product'}->{'name'},
                                        array('dot' => false, 'ampersand' => 'strict', 'cspec' => '', 'rspec' => '')
                                    );
                                }
                                if($this->getResult()->{'product'}->{'price'} != ''){
                                    $price = number_format(floatval($this->getResult()->{'product'}->{'price'}), 2, '.', '');
                                }else{
                                    $price = null;
                                }

                                $parse = array(
                                    'id' => $this->getResult()->{'product'}->{'id'},
                                    'name' => $this->getResult()->{'product'}->{'name'},
                                    'url' => $url,
                                    'price' => $price,
                                    'content' => $this->getResult()->{'product'}->{'description'}
                                );
                            }elseif ($operations['scrud'] === 'delete') {
                                $parse = array(
                                    'id' => $this->getResult()->{$operations['context']}->{'id'}
                                );
                            }
                        }elseif ($operations['context'] === 'related') {
                            if ($operations['scrud'] === 'create') {
                                $parse = array(
                                    'related'  => $this->getResult()->{'product'}->{'related'}
                                );
                            }elseif ($operations['scrud'] === 'delete') {
                                $parse = array(
                                    'related'  => $this->getResult()->{'product'}->{'related'}
                                );
                            }
                        }elseif ($operations['context'] === 'gallery') {
                            if ($operations['scrud'] === 'delete') {
                                foreach($this->getResult()->{'images'} as $key){
                                    //$parse['image'] = $key;
                                    $parse = array(
                                        'image'  => $key
                                    );
                                }
                            }
                        }
                    }
                    break;
            }
            if ($parse) {
                return $parse;
            }
        }catch (Exception $e) {
            magixglobal_model_system::magixlog('Parse error object :',$e);
        }
    }

    /**
     * Set post data after validation
     * @param $operations
     * @param $dataValidate
     * @param bool $debug
     */
    public function setPostData($operations,$dataValidate,$debug = false){
        if($debug){
            $this->getResult($debug);
            print_r($dataValidate);
            print_r($operations);
        }else{
            $parse = $this->setParse($operations);
            /**
             * Data validate from POST
             */
            foreach($dataValidate as $input){
                /*print '<br>';
                print $input.'<br>';
                print_r($parse).'<br>';*/
                /*!($parse[$input]) OR */
                if ($parse[$input] === null OR !array_key_exists($input,$parse)){
                    $this->message->json_post_response(false,'error',self::$notify,'Params : '.$input.' is not valid');
                    return;
                }else{
                    if($operations['scrud'] === 'create') {
                        if($operations['retrieve'] === 'categories'
                            && $operations['context'] === 'subcategory'){
                            parent::insertNewData(array(
                                'type'      => $operations['type'],
                                'retrieve'  => $operations['retrieve'],
                                'context'   => $operations['context'],
                                'name'      => $parse['name'],
                                'url'       => $parse['url'],
                                'content'   => $parse['content'],
                                'idparent'  => $operations['parent']
                            ));
                        }elseif($operations['retrieve'] === 'categories'
                            && $operations['context'] === 'product'){
                            parent::insertNewData(array(
                                'type'          => $operations['type'],
                                'retrieve'      => $operations['retrieve'],
                                'context'       => $operations['context'],
                                'category'      => $operations['category'],
                                'subcategory'   => $parse['subcategory'],
                                'product'       => $parse['product'],
                            ));
                        }elseif($operations['retrieve'] === 'subcategories'
                            && $operations['context'] === 'product'){
                            parent::insertNewData(array(
                                'type'          => $operations['type'],
                                'retrieve'      => $operations['retrieve'],
                                'context'       => $operations['context'],
                                'category'      => $parse['category'],
                                'subcategory'   => $operations['subcategory'],
                                'product'       => $parse['product'],
                            ));
                        }elseif($operations['retrieve'] === 'products'
                            && $operations['context'] === 'product'){
                            parent::insertNewData(array(
                                'type'      => $operations['type'],
                                'retrieve'  => $operations['retrieve'],
                                'context'   => $operations['context'],
                                'idlang'    => $parse['idlang'],
                                'name'      => $parse['name'],
                                'url'       => $parse['url'],
                                'price'     => $parse['price'],
                                'content'   => $parse['content']
                            ));
                        }elseif($operations['retrieve'] === 'products'
                            && $operations['context'] === 'related'){
                            parent::insertNewData(array(
                                'type'      => $operations['type'],
                                'retrieve'  => $operations['retrieve'],
                                'context'   => $operations['context'],
                                'id'        => $operations['id'],
                                'related'   => $parse['related']
                            ));
                        }else{
                            parent::insertNewData(array(
                                'type'      => $operations['type'],
                                'retrieve'  =>$operations['retrieve'],
                                'context'   => $operations['context'],
                                'name'      => $parse['name'],
                                'url'       => $parse['url'],
                                'content'   => $parse['content'],
                                'idlang'    => $parse['idlang']
                            ));
                        }
                        $this->message->json_post_response(true,'success',self::$notify,'Add success');
                    }elseif($operations['scrud'] === 'update'){
                        if($operations['retrieve'] === 'products'
                            && $operations['context'] === 'product'){
                            parent::updateData(array(
                                'type'      => $operations['type'],
                                'context'   => $operations['context'],
                                'id'        => $parse['id'],
                                'name'      => $parse['name'],
                                'url'       => $parse['url'],
                                'content'   => $parse['content'],
                                'price'     => $parse['price']
                            ));
                        }else {
                            parent::updateData(array(
                                'type'      => $operations['type'],
                                'context'   => $operations['context'],
                                'id'        => $parse['id'],
                                'name'      => $parse['name'],
                                'url'       => $parse['url'],
                                'content'   => $parse['content']
                            ));
                        }
                        $this->message->json_post_response(true,'success',self::$notify,'Update success');
                    }elseif($operations['scrud'] === 'delete'){
                        if($operations['retrieve'] === 'products'
                            && $operations['context'] === 'product'){
                            $data = parent::fetchCatalog(array('retrieve'=>'products','context'=>'product','fetch' => 'one', 'id' => $parse['id']));
                            $this->webservice->setRemoveImage(
                                array(
                                    'name' => $data['imgcatalog'],
                                    //'prefix'=> array('l_','m_','s_'),
                                    'attr_name' => 'catalog',
                                    'attr_size' => 'product'
                                ),
                                array(
                                    'type' => 'catalog',
                                    'upload_dir' => array('product', 'medium', 'mini')
                                )
                            );
                            parent::deleteData(array(
                                'type'      => $operations['type'],
                                'retrieve'  => $operations['retrieve'],
                                'context'   => $operations['context'],
                                'id'        => $parse['id']
                            ));
                        }elseif($operations['retrieve'] === 'categories'
                            && $operations['context'] === 'category'){
                            $data = parent::fetchCatalog(array('retrieve'=>'categories','context'=>'category','fetch' => 'one', 'id' => $parse['id']));
                            $this->webservice->setRemoveImage(
                                array(
                                    'name' => $data['img_c'],
                                    //'prefix'=> array('l_','m_','s_'),
                                    'attr_name' => 'catalog',
                                    'attr_size' => 'category'
                                ),
                                array(
                                    'type' => 'catalog',
                                    'upload_dir' => array('category')
                                )
                            );
                            parent::deleteData(array(
                                'type'      => $operations['type'],
                                'retrieve'  => $operations['retrieve'],
                                'context'   => $operations['context'],
                                'id'        => $parse['id']
                            ));
                        }elseif($operations['retrieve'] === 'subcategories'
                            && $operations['context'] === 'subcategory'){
                            $data = parent::fetchCatalog(array('retrieve'=>'subcategories','context'=>'subcategory','fetch' => 'one', 'id' => $parse['id']));
                            $this->webservice->setRemoveImage(
                                array(
                                    'name' => $data['img_s'],
                                    //'prefix'=> array('l_','m_','s_'),
                                    'attr_name' => 'catalog',
                                    'attr_size' => 'subcategory'
                                ),
                                array(
                                    'type' => 'catalog',
                                    'upload_dir' => array('subcategory')
                                )
                            );
                            parent::deleteData(array(
                                'type'      => $operations['type'],
                                'retrieve'  => $operations['retrieve'],
                                'context'   => $operations['context'],
                                'id'        => $parse['id']
                            ));
                        }elseif($operations['retrieve'] === 'categories'
                            && $operations['context'] === 'product'){
                            parent::deleteData(array(
                                'type'      => $operations['type'],
                                'retrieve'  => $operations['retrieve'],
                                'context'   => $operations['context'],
                                'id'        => $parse['id'],
                                'category'  => $operations['category']
                            ));
                        }elseif($operations['retrieve'] === 'subcategories'
                            && $operations['context'] === 'product'){
                            parent::deleteData(array(
                                'type'          => $operations['type'],
                                'retrieve'      => $operations['retrieve'],
                                'context'       => $operations['context'],
                                'id'            => $parse['id'],
                                'subcategory'   => $operations['subcategory']
                            ));
                        }elseif($operations['retrieve'] === 'products'
                            && $operations['context'] === 'related'){
                            parent::deleteData(array(
                                'type'      => $operations['type'],
                                'retrieve'  => $operations['retrieve'],
                                'context'   => $operations['context'],
                                'id'        => $operations['id'],
                                'related'   => $parse['related']
                            ));
                        }
                        $this->message->json_post_response(true, 'success', self::$notify, 'Delete success');
                    }
                    return;
                }
            }
        }
    }
    /**
     * Set catalog
     */
    private function setCatalog($debug){
        $getContentType = $this->webservice->getContentType();
        $this->webservice->setHeaderType();
        switch ($this->retrieve){
            case 'categories':
                if(isset($this->id)){
                    if($this->webservice->setMethod() === 'PUT'){
                        if($getContentType === 'xml' OR $getContentType === 'json'){
                            $this->setPostData(
                                array(
                                    'type'      =>  'catalog',
                                    'retrieve'  =>  'categories',
                                    'context'   =>  'category',
                                    'scrud'     =>  'update',
                                    'id'        =>  $this->id
                                ),
                                array(
                                    'name','url','content'
                                ),
                                $debug
                            );
                        }
                    }elseif($this->webservice->setMethod() === 'POST'){
                        if($getContentType === 'xml' OR $getContentType === 'json') {
                            if(isset($this->action)) {
                                switch ($this->action) {
                                    case 'child':
                                        $this->setPostData(
                                            array(
                                                'type'      => 'catalog',
                                                'retrieve'  => 'categories',
                                                'context'   => 'subcategory',
                                                'scrud'     => 'create',
                                                'parent'    => $this->id
                                            ),
                                            array(
                                                'name', 'url', 'content', 'idparent'
                                            ),
                                            $debug
                                        );
                                        break;
                                    case 'product':
                                        $this->setPostData(
                                            array(
                                                'type'      => 'catalog',
                                                'retrieve'  => 'categories',
                                                'context'   => 'product',
                                                'category'  => $this->id,
                                                'scrud'     => 'create'
                                            ),
                                            array(
                                                'subcategory', 'product'
                                            ),
                                            $debug
                                        );
                                        break;
                                }
                            }
                        }elseif($getContentType === 'files'){
                            if(isset($this->img)) {
                                // POST image from forms
                                $data = $this->dbCatalog->s_category_data($this->id);
                                $resultUpload = $this->webservice->setUploadImage(
                                    'img',
                                    array(
                                        'name'      => magixglobal_model_cryptrsa::random_generic_ui(),
                                        'edit'      => $data['img_c'],
                                        'attr_name' => 'catalog',
                                        'attr_size' => 'category'
                                    ),
                                    array(
                                        'type'      => 'catalog',
                                        'context'   => array('category')
                                    ),
                                    $debug
                                );
                                if($resultUpload['statut']){
                                    parent::updateData(array(
                                        'type'      => 'catalog',
                                        'context'   => 'category',
                                        'id'        => $this->id,
                                        'img'       => $resultUpload['file']
                                    ));
                                }
                                $this->message->json_post_response($resultUpload['statut'], $resultUpload['notify'], self::$notify, $resultUpload['msg']);
                            }
                        }
                    }elseif($this->webservice->setMethod() === 'DELETE'){
                        if (isset($this->action)) {
                            switch ($this->action) {
                                case 'product':
                                    $this->setPostData(
                                        array(
                                            'type'      =>  'catalog',
                                            'retrieve'  =>  'categories',
                                            'context'   =>  'product',
                                            'scrud'     =>  'delete',
                                            'category'  => $this->id
                                        ),
                                        array(
                                            'id','category'
                                        ),
                                        $debug
                                    );
                                    break;
                            }
                        }
                    }else{
                        $this->outputxml->getXmlHeader();
                        $this->getCatalogCategory($this->id);
                    }

                }else{
                    if($this->webservice->setMethod() === 'POST'){
                        if($getContentType === 'xml' OR $getContentType === 'json'){
                            $this->setPostData(
                                array(
                                    'type'      =>  'catalog',
                                    'retrieve'  => 'categories',
                                    'context'   =>  'category',
                                    'scrud'     =>  'create'
                                ),
                                array(
                                    'name','idlang','url','content'
                                ),
                                $debug
                            );
                        }
                    }elseif($this->webservice->setMethod() === 'DELETE'){
                        $this->setPostData(
                            array(
                                'type'      =>  'catalog',
                                'retrieve'  =>  'categories',
                                'context'   =>  'category',
                                'scrud'     =>  'delete'
                            ),
                            array(
                                'id'
                            ),
                            $debug
                        );
                        break;
                    }else{
                        $this->outputxml->getXmlHeader();
                        $this->getCatalogCategories();
                    }
                }
                break;
            case 'subcategories':
                if(isset($this->id)){
                    if($this->webservice->setMethod() === 'POST'){
                        if($getContentType === 'xml' OR $getContentType === 'json'){
                            if (isset($this->action)) {
                                switch ($this->action) {
                                    case 'product':
                                        $this->setPostData(
                                            array(
                                                'type'          => 'catalog',
                                                'retrieve'      => 'subcategories',
                                                'context'       => 'product',
                                                'subcategory'   => $this->id,
                                                'scrud'         => 'create'
                                            ),
                                            array(
                                                'subcategory', 'product'
                                            ),
                                            $debug
                                        );
                                        break;
                                }
                            }
                        }if($getContentType === 'files'){
                            if(isset($this->img)) {
                                // POST image from forms
                                $data = $this->dbCatalog->s_subcategory_data($this->id);
                                $resultUpload = $this->webservice->setUploadImage(
                                    'img',
                                    array(
                                        'name'      => magixglobal_model_cryptrsa::random_generic_ui(),
                                        'edit'      => $data['img_s'],
                                        //'prefix'=> array('l_','m_','s_'),
                                        'attr_name' => 'catalog',
                                        'attr_size' => 'subcategory'
                                    ),
                                    array(
                                        'type' => 'catalog',
                                        'upload_dir' => array('subcategory')
                                    ),
                                    $debug
                                );
                                if($resultUpload['statut']){
                                    parent::updateData(array(
                                        'type'      => 'catalog',
                                        'context'   => 'subcategory',
                                        'id'        => $this->id,
                                        'img'       => $resultUpload['file']
                                    ));
                                }
                                $this->message->json_post_response($resultUpload['statut'], $resultUpload['notify'], self::$notify, $resultUpload['msg']);
                            }
                        }
                    }elseif($this->webservice->setMethod() === 'PUT'){
                        if($getContentType === 'xml' OR $getContentType === 'json'){
                            $this->setPostData(
                                array(
                                    'type'      => 'catalog',
                                    'retrieve'  => 'subcategories',
                                    'context'   => 'subcategory',
                                    'scrud'     => 'update',
                                    'id'        => $this->id
                                ),
                                array(
                                    'name', 'url', 'content'
                                ),
                                $debug
                            );
                        }
                    }elseif($this->webservice->setMethod() === 'DELETE'){
                        if($getContentType === 'xml' OR $getContentType === 'json') {
                            if (isset($this->action)) {
                                switch ($this->action) {
                                    case 'product':
                                        $this->setPostData(
                                            array(
                                                'type'        => 'catalog',
                                                'retrieve'    => 'subcategories',
                                                'context'     => 'product',
                                                'scrud'       => 'delete',
                                                'subcategory' => $this->id
                                            ),
                                            array(
                                                'id', 'subcategory'
                                            ),
                                            $debug
                                        );
                                        break;
                                }
                            }
                        }
                    }else{
                        $this->outputxml->getXmlHeader();
                        $this->getCatalogSubCategories($this->id);
                    }
                }else{
                    if($this->webservice->setMethod() === 'DELETE'){
                        if($getContentType === 'xml' OR $getContentType === 'json') {
                            $this->setPostData(
                                array(
                                    'type'      => 'catalog',
                                    'retrieve'  => 'subcategories',
                                    'context'   => 'subcategory',
                                    'scrud'     => 'delete'
                                ),
                                array(
                                    'id'
                                ),
                                $debug
                            );
                        }
                    }
                }
                break;
            case 'products':
                if(isset($this->id)){
                    if($this->webservice->setMethod() === 'PUT'){
                        if($getContentType === 'xml' OR $getContentType === 'json'){
                            $this->setPostData(
                                array(
                                    'type'      => 'catalog',
                                    'retrieve'  => 'products',
                                    'context'   => 'product',
                                    'scrud'     => 'update',
                                    'id'        => $this->id
                                ),
                                array(
                                    'name', 'url', 'price', 'content'
                                ),
                                $debug
                            );
                        }
                    }elseif($this->webservice->setMethod() === 'POST'){
                        if($getContentType === 'xml' OR $getContentType === 'json'){
                            if (isset($this->action)) {
                                if ($this->action === 'related') {
                                    $this->setPostData(
                                        array(
                                            'type'      => 'catalog',
                                            'retrieve'  => 'products',
                                            'context'   => 'related',
                                            'scrud'     => 'create',
                                            'id'        => $this->id
                                        ),
                                        array(
                                            'related'
                                        ),
                                        $debug
                                    );
                                }
                            }
                        }elseif($getContentType === 'files'){
                            if (isset($this->action)) {
                                if ($this->action === 'gallery') {
                                    // POST image from forms
                                    $resultUpload = $this->webservice->setUploadImage(
                                        'img',
                                        array(
                                            'name'      => magixglobal_model_cryptrsa::random_generic_ui(),
                                            'edit'      => null,
                                            //'prefix'=> array('l_','m_','s_'),
                                            'attr_name' => 'catalog',
                                            'attr_size' => 'galery'
                                        ),
                                        array(
                                            'type'        => 'catalog',
                                            'upload_dir'  => array('galery/maxi', 'galery/mini')
                                        ),
                                        $debug
                                    );
                                    if ($resultUpload['statut']) {
                                        parent::insertNewData(array(
                                            'type'      => 'catalog',
                                            'retrieve'  => 'products',
                                            'context'   => 'product',
                                            'id'        => $this->id,
                                            'img'       => $resultUpload['file']
                                        ));
                                    }
                                    $this->message->json_post_response($resultUpload['statut'], $resultUpload['notify'], self::$notify, $resultUpload['msg']);
                                }
                            }else{
                                if(isset($this->img)) {
                                    // POST image from forms
                                    $data = parent::fetchCatalog(array('context'=>'product','fetch' => 'one', 'id' => $this->id));
                                    $resultUpload = $this->webservice->setUploadImage(
                                        'img',
                                        array(
                                            'name'      => magixglobal_model_cryptrsa::random_generic_ui(),
                                            'edit'      => $data['imgcatalog'],
                                            //'prefix'=> array('l_','m_','s_'),
                                            'attr_name' => 'catalog',
                                            'attr_size' => 'product'
                                        ),
                                        array(
                                            'type'       => 'catalog',
                                            'upload_dir' => array('product', 'medium', 'mini')
                                        ),
                                        $debug
                                    );
                                    if ($resultUpload['statut']) {
                                        parent::updateData(array(
                                            'type'      => 'catalog',
                                            'context'   => 'product',
                                            'id'        => $this->id,
                                            'img'       => $resultUpload['file']
                                        ));
                                    }
                                    $this->message->json_post_response($resultUpload['statut'], $resultUpload['notify'], self::$notify, $resultUpload['msg']);
                                }
                            }
                        }
                    }elseif($this->webservice->setMethod() === 'DELETE'){
                        if($getContentType === 'xml' OR $getContentType === 'json') {
                            if (isset($this->action)) {
                                if ($this->action === 'gallery') {
                                    $parse = $this->setParse(
                                        array(
                                            'type'      => 'catalog',
                                            'retrieve'  => 'products',
                                            'context'   => 'gallery',
                                            'scrud'     => 'delete'
                                        )
                                    );
                                    if(is_array($parse)) {
                                        foreach($parse['image'] as $key){
                                            parent::deleteData(array(
                                                'type'      => 'catalog',
                                                'retrieve'  => 'products',
                                                'context'   => 'gallery',
                                                'image'     => $key
                                            ));
                                            $this->webservice->setRemoveImage(
                                                array(
                                                    'name'      => $key,
                                                    //'prefix'=> array('l_','m_','s_'),
                                                    'attr_name' => 'catalog',
                                                    'attr_size' => 'galery'
                                                ),
                                                array(
                                                    'type'       => 'catalog',
                                                    'upload_dir' => array('galery/maxi', 'galery/mini')
                                                ),
                                                $debug
                                            );
                                        }
                                        $this->message->json_post_response(true, 'success', self::$notify, 'Delete success');
                                    }
                                }elseif ($this->action === 'related') {
                                    $this->setPostData(
                                        array(
                                            'type'      => 'catalog',
                                            'retrieve'  => 'products',
                                            'context'   => 'related',
                                            'scrud'     => 'delete',
                                            'id'        => $this->id
                                        ),
                                        array(
                                            'related'
                                        ),
                                        $debug
                                    );
                                }
                            }
                        }
                    }else{
                        $this->outputxml->getXmlHeader();
                        $this->getCatalogProduct($this->id);
                    }
                }else{
                    if($this->webservice->setMethod() === 'POST'){
                        if($getContentType === 'xml' OR $getContentType === 'json'){
                            $this->setPostData(
                                array(
                                    'type'      => 'catalog',
                                    'retrieve'  => 'products',
                                    'context'   => 'product',
                                    'scrud'     => 'create'
                                ),
                                array(
                                    'name', 'idlang', 'url', 'price', 'content'
                                ),
                                $debug
                            );
                        }
                    }elseif($this->webservice->setMethod() === 'DELETE'){
                        if($getContentType === 'xml' OR $getContentType === 'json') {
                            $this->setPostData(
                                array(
                                    'type'      => 'catalog',
                                    'retrieve'  => 'products',
                                    'context'   => 'product',
                                    'scrud'     => 'delete'
                                ),
                                array(
                                    'id'
                                ),
                                $debug
                            );
                        }
                    }else{
                        $this->outputxml->getXmlHeader();
                        $this->getCatalogProducts();
                    }
                }
            break;
        }
    }

    /**
     * Execute webservice function
     */
    public function run()
    {
        // If authorization is true
        if ($this->webservice->authorization($this->webservice->setWsAuthKey())) {
            if(isset($this->debug)){
                $debug = $this->debug;
            }else{
                $debug = false;
            }
            // If collection defined
            if (isset($this->collection)) {
                switch ($this->collection) {
                    case 'catalog':
                        if (isset($this->retrieve)) {
                            $this->setCatalog($debug);
                        } else {
                            $this->outputxml->getXmlHeader();
                            $this->getCatalogRoot();
                        }
                        break;
                }
            } else {
                $this->outputxml->getXmlHeader();
                $this->getRoot();
            }
        }
    }
}