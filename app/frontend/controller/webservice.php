<?php
class frontend_controller_webservice{
    protected $outputxml;
    public $collection,$retrieve,$id,$data;
    public function __construct(){

        $this->webservice = new frontend_model_webservice();
        $this->outputxml = new magixglobal_model_outputxml();
        $this->dbCatalog = new frontend_db_catalog();
        $this->Catalog = new frontend_model_catalog();
        $this->url = magixcjquery_html_helpersHtml::getUrl();
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
        // POST
        if(magixcjquery_filter_request::isPost('data')){
            $this->data = magixcjquery_form_helpersforms::arrayClean($_POST['data']);
        }
    }
    private function setWsAuthKey(){
        return "ZQ88PRJX5VWQHCWE4EE7SQ7HPNX00RAJ";
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
                            'name'=>'id',
                            'content'=>$key['idclc']
                        )
                    ),
                    'attrNS'=>array(
                        array(
                            'prefix'=>'xlink','name'=>'href',
                            'uri'=>$this->url.'/webservice/catalog/category/'.$key['idclc']
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
    private function getCatalogCategory($id)
    {

        $data = $this->dbCatalog->s_category_data($id);

        $dataClean = $this->Catalog->setItemData($data, 0);
        $data_2 = $this->Catalog->fetchSubCategory(
            array(
                'fetch' => 'in_cat',
                'idclc' => $id
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
                'text' => $dataClean['url']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'description',
                'cData' => $dataClean['content']
            )
        );
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
        $this->outputxml->setElement(
            array(
                'start' => 'order',
                'text' => $dataClean['order']
            )
        );
        // Load Subcategories in category
        $this->outputxml->newStartElement('subcategories');
        if($data_2 != null) {
            foreach ($data_2 as $key) {
                $this->outputxml->setElement(
                    array(
                        'start' => 'subcategory',
                        'attrNS' => array(
                            array(
                                'prefix' => 'xlink',
                                'name' => 'href',
                                'uri' => $this->url . '/webservice/catalog/subcategory/' . $key['idcls']
                            )
                        )
                    )
                );
            }
        }
        $this->outputxml->newEndElement();

        $this->outputxml->newEndElement();
        $this->outputxml->output();
    }

    /**
     * get catalog categories id
     * @param $id
     */
    private function getCatalogSubCategory($id)
    {

        $data = $this->dbCatalog->s_subcategory_data($id);
        $dataClean = $this->Catalog->setItemData($data, 0);

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
                'text' => $dataClean['url']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'description',
                'cData' => $dataClean['content']
            )
        );
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
        $this->outputxml->setElement(
            array(
                'start' => 'order',
                'text' => $dataClean['order']
            )
        );
        $this->outputxml->newEndElement();

        $this->outputxml->newEndElement();
        $this->outputxml->output();
    }

    /**
     * Set catalog
     */
    private function setCatalog(){
        switch ($this->retrieve){
            case 'categories':
                if(isset($this->id)){
                    if($_POST){
                        if($this->webservice->authorization($this->setWsAuthKey())){

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
                            //print_r($this->getResult());
                            print 'name: '.$this->getResult()->{'category'}->{'name'}.'<br />';
                            print 'content: '.$this->getResult()->{'category'}->{'description'};
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
                    if($this->webservice->authorization($this->setWsAuthKey())){
                        $this->outputxml->getXmlHeader();
                        $this->getCatalogSubCategory($this->id);
                    }
                }
                break;
        }
    }
    public function preparePostData($data){
        $curl_params = array();
        $encodedAuth = $this->setWsAuthKey();
        $generated_xml = urlencode($data['request']);
        $options = array(
            CURLOPT_HEADER          => 0,
            CURLOPT_RETURNTRANSFER  => true,
            CURLINFO_HEADER_OUT     => true,
            CURLOPT_URL             => $data['url'],
            CURLOPT_HTTPAUTH        => CURLAUTH_BASIC,
            CURLOPT_USERPWD         => $encodedAuth,
            CURLOPT_HTTPHEADER      => array("Authorization : Basic ".$encodedAuth),
            CURLOPT_CUSTOMREQUEST   => "POST",
            CURLOPT_POSTFIELDS      => $data['method']."=".$generated_xml
        );
        $ch = curl_init();
        curl_setopt_array($ch,$options);
        $response = curl_exec($ch);
        $curlInfo = curl_getinfo($ch);
        curl_close ($ch);
        if($response){
            print $response;
        }
    }
    public function setPostData($data){
        switch($data['method']){
            case 'xml':
                return simplexml_load_string($_POST[$data['method']], null, LIBXML_NOCDATA);
                break;
            case 'json':
                return json_decode($_POST[$data['method']]);
                break;
        }
    }
    public function getResult($filter = false){

        /*$filter = array(
            'name','content'
        );
        foreach($filter as $input){
            if (!($_POST[$input]) OR $_POST[$input] == null OR $_POST[$input] == ''){
                return;
            }
        }*/

        $keyPost = array_keys($_POST);
        if(in_array("json",$keyPost) || in_array("xml",$keyPost)){
            $parse = $this->setPostData(array('method'=>$keyPost[0]));
            if(is_object($parse)){
                return $parse;
            }
        }
    }
    /**
     * Execute webservice function
     */
    public function run(){
        if(isset($this->collection)){
            switch ($this->collection){
                case 'catalog':
                    $this->setCatalog();
                    break;
            }
        } else{
            $curl_params = array();
            $encodedAuth = $this->setWsAuthKey();
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
            $test = '<?xml version="1.0" encoding="UTF-8" ?>
            <magixcms>
                <category>
                    <name>rthrthrt</name>
                    <url>mon-url</url>
                    <description>
                        <![CDATA[<div id="lipsum">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam felis ex, blandit accumsan risus quis, eleifend mollis nisi. Mauris in augue dui. Nulla accumsan neque at dignissim consequat. In pharetra dignissim lorem, ac aliquet purus varius et. Cras fermentum sit amet elit et varius. Integer dui leo, pretium eget viverra vel, bibendum vel est. Pellentesque commodo, magna sed consequat eleifend, odio ligula venenatis sapien, eget aliquet orci augue ultricies velit. Sed cursus accumsan sapien, at gravida libero dignissim ut. Nulla facilisi. Aliquam augue nunc, suscipit ut elit eget, ullamcorper sagittis arcu.</p>
                        <p>Ut scelerisque, dui eleifend sollicitudin varius, libero ligula consectetur ligula, sit amet tristique dui lorem ut tortor. Nam commodo ipsum quam, eget finibus eros semper malesuada. Curabitur eget pellentesque lacus, et tincidunt dui. Sed congue bibendum purus, et lacinia enim lacinia quis. Proin interdum eu leo ut hendrerit. Nam at maximus risus. Cras nec volutpat est, vel malesuada nisi. Nullam in mi in dolor malesuada ornare. In sed massa massa.</p>
                        </div>]]>
                    </description>
                </category>
            </magixcms>';
            $json = json_encode(array('name'=>'test','content'=>'test avec json'));
            /*$generated_xml = urlencode($json);
            $options = array(
                CURLOPT_HEADER          => 0,
                CURLOPT_RETURNTRANSFER  => true,
                CURLINFO_HEADER_OUT     => true,
                CURLOPT_URL             => 'http://www.magixcms.dev/webservice/catalog/categories',
                CURLOPT_HTTPAUTH        => CURLAUTH_BASIC,
                CURLOPT_USERPWD         => $encodedAuth,
                CURLOPT_HTTPHEADER      => array("Authorization : Basic ".$encodedAuth,/*"application/x-www-form-urlencoded","Content-Type: text/xml; charset=UTF-8"*///),
                /*CURLOPT_CUSTOMREQUEST   => "POST",
                CURLOPT_POSTFIELDS      => "json=".$generated_xml
            );
            $ch = curl_init();
            curl_setopt_array($ch,$options);
            $response = curl_exec($ch);
            //print_r($response);
            $curlInfo = curl_getinfo($ch);
            /*$index = strpos($response, "\r\n\r\n");
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
            }*/
            /*curl_close ($ch);
            //print '<pre>';
            //print_r($response);
            //print_r($curlInfo);
            //print_r(array('status_code' => $curlInfo['http_code'],"request_header"=>$curlInfo['request_header'], 'response' => $body, 'header' => $header));
            //print '</pre>';
            //print $body;
            //}
            //$this->outputxml->getXmlHeader();
            /*$xml = simplexml_load_string($test);
            print_r($xml);*/
            /*if($response){ echo $response; }*/
            $this->preparePostData(array(
                'method'=>'xml',
                'request'=>$test,
                'url'=>'http://www.magixcms.dev/webservice/catalog/categories'
            ));
        }
    }
}