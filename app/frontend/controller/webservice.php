<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2016 magix-cms.com support[at]magix-cms[point]com
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com>
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
    public $collection,$retrieve,$id,$action,$img;
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
        // POST
        if(isset($_FILES['img']["name"])){
            $this->img = magixcjquery_url_clean::rplMagixString($_FILES['img']["name"]);
        }
    }

    /**
     * @return string
     */
    private function setWsAuthKey(){
        return "ZQ88PRJX5VWQHCWE4EE7SQ7HPNX00RAJ";
    }
    // ############## GET
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
                        'attrNS' => array(
                            array(
                                'prefix' => 'xlink',
                                'name' => 'href',
                                'uri' => $this->url . '/webservice/catalog/product/' . $key['idcatalog'].'/'
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
                            'attrNS' => array(
                                array(
                                    'prefix' => 'xlink',
                                    'name' => 'href',
                                    'uri' => $this->url . '/webservice/catalog/product/' . $key['idcatalog'].'/'
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
                'fetch'  =>  'all'
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
                'fetch'     =>  'category',
                'id'        =>  $id
            )
        );
        if($fetchcategory != null) {
            foreach ($fetchcategory as $key) {
                $this->outputxml->setElement(
                    array(
                        'start' => 'category',
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
                'fetch'     =>  'subcategory',
                'id'        =>  $id
            )
        );
        if($fetchcategory != null) {
            foreach ($fetchcategory as $key) {
                $this->outputxml->setElement(
                    array(
                        'start' => 'subcategory',
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

        // Start Image gallery
        $this->outputxml->newStartElement('gallery');
        $fetchGallery = parent::fetchCatalog(
            array(
                'fetch'     =>  'gallery',
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
    //########## POST

    /**
     * @param $data
     * @return mixed|SimpleXMLElement
     */
    public function setPostMethod($data){
        switch($data['method']){
            case 'xml':
                return simplexml_load_string($_POST[$data['method']], null, LIBXML_NOCDATA);
                break;
            case 'json':
                return json_decode($_POST[$data['method']]);
                break;
        }
    }

    /**
     * @param bool $debug
     * @return mixed|SimpleXMLElement
     */
    public function getResult($debug = false){
        if($_POST){
            $keyPost = array_keys($_POST);
            if (in_array("json", $keyPost) || in_array("xml", $keyPost)) {
                $parse = $this->setPostMethod(array('method' => $keyPost[0]));
                if (is_object($parse)) {
                    if($debug){
                        print '<pre>';
                        print_r($keyPost).'<br />';
                        print_r($parse);
                        print '</pre>';
                    }else{
                        return $parse;
                    }
                }
            }
        }
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
                            }
                        } elseif ($operations['context'] === 'product') {
                            if($operations['scrud'] === 'create') {
                                $parse = array(
                                    'product'       => $this->getResult()->{$operations['context']}->{'id'},
                                    'category'      => $this->getResult()->{$operations['context']}->{'category'},
                                    'subcategory'   => $this->getResult()->{$operations['context']}->{'subcategory'}
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
                            }
                        }elseif ($operations['context'] === 'related') {
                            if ($operations['scrud'] === 'create') {
                                $parse = array(
                                    'related'  => $this->getResult()->{'product'}->{'related'}
                                );
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
                                'retrieve'  =>$operations['retrieve'],
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
                                'retrieve'  =>$operations['retrieve'],
                                'context'       => $operations['context'],
                                'category'      => $operations['category'],
                                'subcategory'   => $parse['subcategory'],
                                'product'       => $parse['product'],
                            ));
                        }elseif($operations['retrieve'] === 'subcategories'
                            && $operations['context'] === 'product'){
                            parent::insertNewData(array(
                                'type'          => $operations['type'],
                                'retrieve'      =>$operations['retrieve'],
                                'context'       => $operations['context'],
                                'category'      => $parse['category'],
                                'subcategory'   => $operations['subcategory'],
                                'product'       => $parse['product'],
                            ));
                        }elseif($operations['retrieve'] === 'products'
                            && $operations['context'] === 'product'){
                            parent::insertNewData(array(
                                'type'      => $operations['type'],
                                'retrieve'  =>$operations['retrieve'],
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
                                'type' => $operations['type'],
                                'context' => $operations['context'],
                                'id' => $parse['id'],
                                'name' => $parse['name'],
                                'url' => $parse['url'],
                                'content' => $parse['content'],
                                'price' => $parse['price']
                            ));
                        }else {
                            parent::updateData(array(
                                'type' => $operations['type'],
                                'context' => $operations['context'],
                                'id' => $parse['id'],
                                'name' => $parse['name'],
                                'url' => $parse['url'],
                                'content' => $parse['content']
                            ));
                        }
                        $this->message->json_post_response(true,'success',self::$notify,'Update success');
                    }
                    return;
                }
            }
        }
    }
    /**
     * Set catalog
     */
    private function setCatalog(){
        switch ($this->retrieve){
            case 'categories':
                if(isset($this->id)){
                    if(isset($_POST['xml']) || isset($_POST['json'])){
                        if($this->webservice->authorization($this->setWsAuthKey())){
                            if(isset($this->action)){
                                switch($this->action) {
                                    case 'child':
                                        $this->setPostData(
                                            array(
                                                'type'      => 'catalog',
                                                'retrieve'  => 'categories',
                                                'context'   => 'subcategory',
                                                'scrud'     => 'create',
                                                'parent'    =>  $this->id
                                            ),
                                            array(
                                                'name', 'url', 'content', 'idparent'
                                            )
                                        );
                                        break;
                                    case 'product':
                                        $this->setPostData(
                                            array(
                                                'type'      => 'catalog',
                                                'retrieve'  => 'categories',
                                                'context'   => 'product',
                                                'category'  =>  $this->id,
                                                'scrud'     => 'create'
                                            ),
                                            array(
                                                'subcategory','product'
                                            )
                                        );
                                        break;
                                }
                            }else{
                                $this->setPostData(
                                    array(
                                        'type'      =>  'catalog',
                                        'retrieve'  => 'categories',
                                        'context'   =>  'category',
                                        'scrud'     =>  'update',
                                        'id'        =>  $this->id
                                    ),
                                    array(
                                        'name','url','content'
                                    )
                                );
                            }
                        }
                    }elseif(isset($this->img)) {
                        // POST image from forms
                        if($this->webservice->authorization($this->setWsAuthKey())) {
                            $data = $this->dbCatalog->s_category_data($this->id);
                            $resultUpload = $this->webservice->setUploadImage(
                                'img',
                                array(
                                    'name' => magixglobal_model_cryptrsa::random_generic_ui(),
                                    'edit' => $data['img_c'],
                                    'attr_name' => 'catalog',
                                    'attr_size' => 'category'
                                ),
                                array(
                                    'type' => 'catalog',
                                    'context' => array('category')
                                )
                            );
                            if($resultUpload['statut']){
                                parent::updateData(array(
                                    'type'      => 'catalog',
                                    'context'   => 'category',
                                    'id'        => $this->id,
                                    'img'      => $resultUpload['file']
                                ));
                            }
                            $this->message->json_post_response($resultUpload['statut'], $resultUpload['notify'], self::$notify, $resultUpload['msg']);
                        }
                    }else{
                        if($this->webservice->authorization($this->setWsAuthKey())){
                            $this->outputxml->getXmlHeader();
                            $this->getCatalogCategory($this->id);
                        }
                    }

                }else{
                    if(isset($_POST['xml']) || isset($_POST['json'])){
                        if($this->webservice->authorization($this->setWsAuthKey())){
                            $this->setPostData(
                                array(
                                    'type'      =>  'catalog',
                                    'retrieve'  => 'categories',
                                    'context'   =>  'category',
                                    'scrud'     =>  'create'
                                ),
                                array(
                                    'name','idlang','url','content'
                                )
                            );
                        }
                    }else{
                        if($this->webservice->authorization($this->setWsAuthKey())){
                            $this->outputxml->getXmlHeader();
                            $this->getCatalogCategories();
                        }
                    }
                }
                break;
            case 'subcategories':
                if(isset($this->id)){
                    if(isset($_POST['xml']) || isset($_POST['json'])){
                        if(isset($this->action)){
                            switch($this->action) {
                                case 'product':
                                    $this->setPostData(
                                        array(
                                            'type'      => 'catalog',
                                            'retrieve'  =>  'subcategories',
                                            'context'   => 'product',
                                            'subcategory'  =>  $this->id,
                                            'scrud'     => 'create'
                                        ),
                                        array(
                                            'subcategory','product'
                                        )
                                    );
                                    break;
                            }
                        }else{
                            $this->setPostData(
                                array(
                                    'type'      =>  'catalog',
                                    'retrieve'  =>  'subcategories',
                                    'context'   =>  'subcategory',
                                    'scrud'     =>  'update',
                                    'id'        =>  $this->id
                                ),
                                array(
                                    'name','url','content'
                                )
                            );
                        }
                    }elseif(isset($this->img)) {
                        // POST image from forms
                        if($this->webservice->authorization($this->setWsAuthKey())) {
                            $data = $this->dbCatalog->s_subcategory_data($this->id);
                            $resultUpload = $this->webservice->setUploadImage(
                                'img',
                                array(
                                    'name' => magixglobal_model_cryptrsa::random_generic_ui(),
                                    'edit' => $data['img_s'],
                                    //'prefix'=> array('l_','m_','s_'),
                                    'attr_name' => 'catalog',
                                    'attr_size' => 'subcategory'
                                ),
                                array(
                                    'type' => 'catalog',
                                    'upload_dir' => array('subcategory')
                                )
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
                    }else{
                        if($this->webservice->authorization($this->setWsAuthKey())){
                            $this->outputxml->getXmlHeader();
                            $this->getCatalogSubCategories($this->id);
                        }
                    }
                }
                break;
            case 'products':
                if(isset($this->id)){
                    if(isset($_POST['xml']) || isset($_POST['json'])){
                        if(isset($this->action)){
                            if($this->action === 'related') {
                                $this->setPostData(
                                    array(
                                        'type' => 'catalog',
                                        'retrieve' => 'products',
                                        'context' => 'related',
                                        'scrud' => 'create',
                                        'id' => $this->id
                                    ),
                                    array(
                                        'related'
                                    )
                                );
                            }
                        }else{
                            $this->setPostData(
                                array(
                                    'type'      =>  'catalog',
                                    'retrieve'  =>  'products',
                                    'context'   =>  'product',
                                    'scrud'     =>  'update',
                                    'id'        =>  $this->id
                                ),
                                array(
                                    'name','url','price','content'
                                )
                            );
                        }
                    }elseif(isset($this->img)) {
                        if(isset($this->action)){
                            if($this->action === 'gallery'){
                                // POST image from forms
                                if($this->webservice->authorization($this->setWsAuthKey())) {
                                    $resultUpload = $this->webservice->setUploadImage(
                                        'img',
                                        array(
                                            'name' => magixglobal_model_cryptrsa::random_generic_ui(),
                                            'edit' => null,
                                            //'prefix'=> array('l_','m_','s_'),
                                            'attr_name' => 'catalog',
                                            'attr_size' => 'galery'
                                        ),
                                        array(
                                            'type' => 'catalog',
                                            'upload_dir' => array('galery/maxi','galery/mini')
                                        )
                                    );
                                    if($resultUpload['statut']){
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
                            }
                        }else{
                            // POST image from forms
                            if($this->webservice->authorization($this->setWsAuthKey())) {
                                $data = parent::fetchCatalog(array('fetch'  =>  'one','id' => $this->id));
                                $resultUpload = $this->webservice->setUploadImage(
                                    'img',
                                    array(
                                        'name' => magixglobal_model_cryptrsa::random_generic_ui(),
                                        'edit' => $data['imgcatalog'],
                                        //'prefix'=> array('l_','m_','s_'),
                                        'attr_name' => 'catalog',
                                        'attr_size' => 'product'
                                    ),
                                    array(
                                        'type' => 'catalog',
                                        'upload_dir' => array('product','medium','mini')
                                    )
                                );
                                if($resultUpload['statut']){
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

                    }else{
                        if($this->webservice->authorization($this->setWsAuthKey())){
                            $this->outputxml->getXmlHeader();
                            $this->getCatalogProduct($this->id);
                        }
                    }
                }else{
                    if(isset($_POST['xml']) || isset($_POST['json'])){
                        $this->setPostData(
                            array(
                                'type'      =>  'catalog',
                                'retrieve'  =>  'products',
                                'context'   =>  'product',
                                'scrud'     =>  'create'
                            ),
                            array(
                                'name','idlang','url','price','content'
                            )
                        );
                    }else{
                        if($this->webservice->authorization($this->setWsAuthKey())){
                            $this->outputxml->getXmlHeader();
                            $this->getCatalogProducts();
                        }
                    }
                }

                break;
        }
    }

    /**
     * Execute webservice function
     */
    public function run(){
        if (isset($this->collection)) {
            switch ($this->collection) {
                case 'catalog':
                    $this->setCatalog();
                    break;
            }
        } else {
            /*$curl_params = array();
            $encodedAuth = $this->setWsAuthKey();*/
            /*$options = array(
                CURLOPT_HEADER          => true,
                CURLOPT_RETURNTRANSFER  => true,
                CURLINFO_HEADER_OUT     => true,
                CURLOPT_URL             => 'http://www.magixcms.dev/webservice/catalog/categories',
                CURLOPT_HTTPAUTH        => CURLAUTH_BASIC,
                CURLOPT_USERPWD         => $encodedAuth,
                CURLOPT_HTTPHEADER => array("Authorization : Basic ".$encodedAuth,"Content-Type: text/xml;charset=utf-8")
            );
            $ch = curl_init();
            curl_setopt_array($ch,$options);
            $response = curl_exec($ch);
            //print_r($response);
            $curlInfo = curl_getinfo($ch);
            $index = strpos($response, "\r\n\r\n");
            if ($index === false && $curl_params[CURLOPT_CUSTOMREQUEST] != 'HEAD'){
                throw new Exception('Bad HTTP response');
            }
            $header = substr($response, 0, $index);
            $body = substr($response, $index + 4);
            $headerArrayTmp = explode("\n", $header);
            $headerArray = array();
            foreach ($headerArrayTmp as &$headerItem)
            {
                $tmp = explode(':', $headerItem);
                $tmp = array_map('trim', $tmp);
                if (count($tmp) == 2)
                    $headerArray[$tmp[0]] = $tmp[1];
            }
            curl_close ($ch);
            header('Content-type: text/xml; charset=UTF-8');*/
            /*print '<pre>';
            //print_r($response);
            //print_r($curlInfo);
            print_r(array('status_code' => $curlInfo['http_code'], 'response' => $body, 'header' => $header));
            print '</pre>';*/
            //print $body;
            //if(isset($this->data)){
            //$data_string = "postvar1=value1&postvar2=value2&postvar3=value3";
            /*$data_string = array(
                    'name' => 'test',
                    'content' => 'mon test'
            );*/
            /*$test = $this->outputxml->newStartElement('categories');
            $test .= $this->outputxml->setElement(
                    array(
                        'start'=>'category',
                        'text'=> 'truc'
                    )
                );

            $test .= $this->outputxml->newEndElement();
            $test .= $this->outputxml->output();*/
            /*$test = '<?xml version="1.0" encoding="UTF-8" ?>
        <magixcms>
            <category>
                <iso>fr</iso>
                <name>Mon titre via webservice xml</name>
                <description>
                    <![CDATA[<div id="lipsum">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam felis ex, blandit accumsan risus quis, eleifend mollis nisi. Mauris in augue dui. Nulla accumsan neque at dignissim consequat. In pharetra dignissim lorem, ac aliquet purus varius et. Cras fermentum sit amet elit et varius. Integer dui leo, pretium eget viverra vel, bibendum vel est. Pellentesque commodo, magna sed consequat eleifend, odio ligula venenatis sapien, eget aliquet orci augue ultricies velit. Sed cursus accumsan sapien, at gravida libero dignissim ut. Nulla facilisi. Aliquam augue nunc, suscipit ut elit eget, ullamcorper sagittis arcu.</p>
                    <p>Ut scelerisque, dui eleifend sollicitudin varius, libero ligula consectetur ligula, sit amet tristique dui lorem ut tortor. Nam commodo ipsum quam, eget finibus eros semper malesuada. Curabitur eget pellentesque lacus, et tincidunt dui. Sed congue bibendum purus, et lacinia enim lacinia quis. Proin interdum eu leo ut hendrerit. Nam at maximus risus. Cras nec volutpat est, vel malesuada nisi. Nullam in mi in dolor malesuada ornare. In sed massa massa.</p>
                    </div>]]>
                </description>
            </category>
        </magixcms>';*/
            
           /* $test = '<?xml version="1.0" encoding="UTF-8" ?>
        <magixcms>
            <category>
                <id>1</id>
                <name>ma ligne de vêtement bleu</name>
                <url></url>
                <description>
                    <![CDATA[<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam felis ex, blandit accumsan risus quis, eleifend mollis nisi.</p>]]>
                </description>
            </category>
        </magixcms>';

            $subcategory = '<?xml version="1.0" encoding="UTF-8" ?>
        <magixcms>
            <subcategory>
                <id>3</id>
                <name>ma sous catégorie ws</name>
                <url>ma-sous-categorie-ws</url>
                <description>
                    <![CDATA[
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam felis ex, blandit accumsan risus quis, eleifend mollis nisi.</p>]]>
                </description>
            </subcategory>
        </magixcms>';

            $product = '<?xml version="1.0" encoding="UTF-8" ?>
        <magixcms>
            <product>
                <id>5</id>
                <category>1</category>
                <subcategory>3</subcategory>
            </product>
        </magixcms>';*/
            /*$subcategory = '<?xml version="1.0" encoding="UTF-8"?>
            <magixcms>
                <subcategory>
                    <id_parent>1</id_parent>
                    <id>3</id>
                    <name>my subcategory</name>
                    <url>my-subcategory</url>
                    <description><![CDATA[
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Nam felis ex, blandit accumsan risus quis, eleifend mollis nisi.</p>
                            ]]></description>
                </subcategory>
            </magixcms>';*/
            $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam felis ex, blandit accumsan risus quis, eleifend mollis nisi. Mauris in augue dui.';
            /*$json = json_encode(array('subcategory'=>array(
                'idparent'      =>  1,
                'id'            =>  3,
                'name'          =>  'Mon titre via webservice json',
                'url'           =>  '',
                'description'   => $description
            )));*/
            /*$json = json_encode(array('category'=>array(
                'iso'           =>'fr',
                'name'          =>  'Mon titre de test json',
                'description'   => $description
            )));*/
            /*$product = json_encode(array('product'=>array(
                'id'            =>  5,
                'category'      =>  1,
                'subcategory'   =>  1
            )));*/
           /*$json = json_encode(array('product'=>array(
               'iso'            =>'fr',
                //'id'            =>  3,
                'name'          =>  'My test',
                'url'           =>  '',
                'price'         =>  '10.80',
                'description'   => $description
            )));
            print_r($json);*/
            /*print $this->webservice->setPreparePostData(array(
                'wsAuthKey'=>$this->setWsAuthKey(),
                'method' => 'json',
                'request' => $product,
                'url' => 'http://www.magixcms.dev/webservice/catalog/categories/1/product/'
            ));*/
            /*$product = '<?xml version="1.0" encoding="UTF-8"?>
            <magixcms>
                <product>
                    <id>20</id>
                    <name>My test update</name>
                    <url></url>
                    <price>178</price>
                    <description><![CDATA[<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam felis ex, blandit accumsan risus quis, eleifend mollis nisi.</p>]]></description>
                </product>
            </magixcms>';*/
            $related = '<?xml version="1.0" encoding="UTF-8"?>
            <magixcms>
                <product>
                    <id>20</id>
                    <related>4</related>
                </product>
            </magixcms>';
            $json = json_encode(array('product'=>array(
                'id'            =>  1,
                'related'          =>  20
            )));
            print_r($json);
            print $this->webservice->setPreparePostData(array(
                'wsAuthKey'=>$this->setWsAuthKey(),
                'method' => 'json',
                'request' => $json,
                'url' => 'http://www.magixcms.dev/webservice/catalog/products/1/related/'
            ));

            
            /*print $this->webservice->setPreparePostImg(array(
                'wsAuthKey' =>  $this->setWsAuthKey(),
                'url'       => 'http://www.magixcms.dev/webservice/catalog/categories/3'
            ));*/
        }
    }
}