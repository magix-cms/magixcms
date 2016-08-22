<?php
class frontend_model_webservice extends frontend_db_webservice{
    /**
     * @var array
     */
    public $contentTypeCollection = array(
        'application/json'      =>'json',
        'text/xml'              =>'xml',
        'multipart/form-data'   =>'files'
    );
    /**
     * @var bool
     */
    protected $with_curl;

    /**
     * frontend_model_webservice constructor.
     */
    public function __construct()
    {
        if (function_exists("curl_init")) {
            $this->with_curl = TRUE;
        } else {
            $this->with_curl = FALSE;
        }
        if(isset($_FILES['img']["name"])){
            $this->img = magixcjquery_url_clean::rplMagixString($_FILES['img']["name"]);
        }
    }
    /* ##################################### Authentification ##########################################*/
    /**
     * @param $mcWsAuthKey
     * @return bool
     */
    public function authorization($mcWsAuthKey){
        if (isset($_SERVER['HTTP_AUTHORIZATION']) && preg_match('/Basic\s+(.*)$/i', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
            list($name, $password) = explode(':', base64_decode($matches[1]));
            $_SERVER['PHP_AUTH_USER'] = strip_tags($name);
        }
        //set http auth headers for apache+php-cgi work around if variable gets renamed by apache
        if (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) && preg_match('/Basic\s+(.*)$/i', $_SERVER['REDIRECT_HTTP_AUTHORIZATION'], $matches)) {
            list($name, $password) = explode(':', base64_decode($matches[1]));
            $_SERVER['PHP_AUTH_USER'] = strip_tags($name);
        }
        // Use for image management (using the POST method of the browser to simulate the PUT method)
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($_SERVER['PHP_AUTH_USER']) AND !empty($_SERVER['PHP_AUTH_USER'])) {
            $key = base64_encode($_SERVER['PHP_AUTH_USER']);
        } elseif (isset($_GET['ws_key'])) {
            $key = base64_encode($_GET['ws_key']);
        } else {
            header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
            header('WWW-Authenticate: Basic realm="Welcome to Magixcms Webservice, please enter the authentication key as the login. No password required."');
            die('401 Unauthorized');
        }

        if($key === base64_encode($mcWsAuthKey)){
            return true;
        }else{
            header($_SERVER['SERVER_PROTOCOL'].' 401 Unauthorized');
            header('WWW-Authenticate: Basic realm="Welcome to Magixcms Webservice, please enter the authentication key as the login. No password required."');
            die('401 Unauthorized');
        }
    }

    /**
     * @return string
     */
    public function setWsAuthKey(){
        $data = parent::fetchConfig(array('type'=>'key'));
        if($data != null){
            if($data['status_key'] != '0'){
                return $data['ws_key'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /* ##################################### Parse XML OR JSON ##########################################*/
    /**
     * request method put, get, post, delete
     * @return mixed
     */
    public function setMethod(){
        if(isset($_SERVER['REQUEST_METHOD'])){
            return $_SERVER['REQUEST_METHOD'];
        }
    }

    /**
     * set content-type header
     * @return array
     */
    private function setContentType(){
        $contentType = explode(";",$_SERVER['CONTENT_TYPE']);
        $contentType = $contentType[0];
        return $contentType;
    }

    /**
     * Return content type for parse détection
     * @return mixed|void
     */
    public function getContentType(){
        if(is_array($this->contentTypeCollection)){
            $contentType = $this->setContentType();
            /*if(preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches)){
                //print $boundary = $matches[1];
                $contentType = explode(";",$_SERVER['CONTENT_TYPE']);
                $contentType = $contentType[0];
            }else{
                $contentType = $_SERVER['CONTENT_TYPE'];
            }*/
            if(!array_key_exists($contentType,$this->contentTypeCollection)){
                return;
            }else{
                return $this->contentTypeCollection[$contentType];
            }
        }
    }

    /**
     * Return header from content type
     */
    public function setHeaderType(){
        $getContentType = $this->getContentType();
        switch($getContentType){
            case 'xml':
                header('Content-type: text/xml');
                break;
            case 'json':
                header('Content-type: application/json');
                break;
        }
    }

    /**
     * Read raw data from the request body
     * @return bool|string
     */
    private function setStreamData(){
        if ($stream = fopen('php://input', 'r')) {
            $streamData = stream_get_contents($stream, -1, 0);
            $streamData = urldecode($streamData);
            fclose($stream);
            return $streamData;
        }else{
            return false;
        }
    }
    /**
     * @param $data
     * @return mixed|SimpleXMLElement
     */
    private function setParseMethod($data){
        switch($data['method']){
            case 'xml':
                return simplexml_load_string($data['data'], null, LIBXML_NOCDATA);
                break;
            case 'json':
                return json_decode($data['data']);
                break;
        }
    }

    /**
     * @param bool $debug
     * @return mixed|SimpleXMLElement
     */
    public function getResultParse($debug = false){
        $parse = $this->setParseMethod(array(
            'method'    =>  $this->getContentType(),
            'data'      =>  $this->setStreamData()
        ));
        if (is_object($parse)) {
            if($debug){
                print $this->getContentType();
                print '<pre>';
                print_r($parse);
                print '</pre>';
            }else{
                return $parse;
            }
        }else{
            return 'Parse result is not object';
        }
    }
    /* ##################################### Image Upload ##########################################*/
    /**
     * Retourne le chemin depuis la racine
     * @param $pathUpload
     * @return string
     */
    public function imgBasePath($pathUpload){
        return magixglobal_model_system::base_path().$pathUpload;
    }

    /**
     * Return path string for upload
     * @param $data
     * @return string
     */
    public function dirImgUpload($data){
        if(is_array($data)){
            if(array_key_exists('type',$data)){
                switch($data['type']){
                    case 'catalog':
                        $type = 'catalogimg';
                        break;
                    case 'news':
                        $type = 'news';
                        break;
                }
                if(array_key_exists('imgBasePath',$data)){
                    if($data['imgBasePath']){
                        $url = $this->imgBasePath("upload".DIRECTORY_SEPARATOR.$type.DIRECTORY_SEPARATOR);
                    }else{
                        $url = "upload".DIRECTORY_SEPARATOR.$type.DIRECTORY_SEPARATOR;
                    }
                }
                return $url;
            }
        }
    }

    /**
     * Return path collection for upload
     * @param $data
     * @return array
     */
    public function dirImgUploadCollection($data){
        if(is_array($data)){
            if(array_key_exists('type',$data)){
                switch($data['type']){
                    case 'catalog':
                        $type = 'catalogimg';
                        break;
                    case 'news':
                        $type = 'news';
                        break;
                }
                if(array_key_exists('upload_dir',$data)){
                    foreach($data['upload_dir'] as $key){
                        $url[] = $this->imgBasePath("upload".DIRECTORY_SEPARATOR.$type.DIRECTORY_SEPARATOR.$key.DIRECTORY_SEPARATOR);
                    }
                }
                return $url;
            }
        }
    }
    /**
     * Set Upload files
     * @param $img
     * @param $data
     * @param $imgCollection
     * @param bool $debug
     * @return array
     */
    public function setUploadImage($img,$data,$imgCollection,$debug=false){
        if(isset($this->$img)){
            try{
                // Charge la classe pour le traitement du fichier
                $makeFiles = new magixcjquery_files_makefiles();
                $resultUpload = null;
                $dirImg = $this->dirImgUpload(array_merge(array('type'=>$imgCollection['type']),array('imgBasePath'=>true)));
                $fetchConfig = parent::fetchConfig(array('type'=>'config','context'=>'imgSize','attr_name'=>$data['attr_name'],'attr_size'=>$data['attr_size']));
                if(!empty($this->$img)){
                    $initImg = new frontend_model_image();
                    /**
                     * Envoi une image dans le dossier "racine" catalogimg
                     */
                    $resultUpload = $initImg->uploadImg(
                        $img,
                        $this->dirImgUpload(array_merge(array('type'=>$imgCollection['type']),array('imgBasePath'=>false))),
                        $debug
                    );
                    /**
                     * Analyze l'extension du fichier en traitement
                     * @var $fileextends
                     */

                    $fileExtends = $initImg->image_analyze($dirImg.$this->$img);
                    if ($initImg->imgSizeMin($dirImg.$this->$img,25,25)){
                        if(file_exists($dirImg.$data['name'].$fileExtends)){
                            $makeFiles->removeFile($dirImg,$data['edit']);
                        }
                        // Renomme le fichier
                        $makeFiles->renameFiles(
                            $dirImg,
                            $dirImg.$this->$img,$dirImg.$data['name'].$fileExtends
                        );
                        /**
                         * Initialisation de la classe phpthumb
                         * @var void
                         */
                        try{
                            $thumb = PhpThumbFactory::create($dirImg.$data['name'].$fileExtends);
                        }catch (Exception $e)
                        {
                            magixglobal_model_system::magixlog('An error has occured :',$e);
                        }
                        /**
                         *
                         * Charge la taille des images des sous catégories du catalogue
                         */

                        if($fetchConfig != null){
                            if(is_array($imgCollection)){
                                $dirImgArray = $this->dirImgUploadCollection($imgCollection);
                                foreach($fetchConfig as $key => $value){
                                    if(array_key_exists('prefix',$data)){
                                        if(is_array($data['prefix'])){
                                            $prefix = $data['prefix'][$key];
                                        }else{
                                            $prefix = '';
                                        }
                                    }else{
                                        $prefix = '';
                                    }
                                    switch($value['img_resizing']){
                                        case 'basic':
                                            $thumb->resize($value['width'],$value['height']);
                                            $thumb->save($dirImgArray[$key].$prefix.$data['name'].$fileExtends);
                                            break;
                                        case 'adaptive':
                                            $thumb->adaptiveResize($value['width'],$value['height']);
                                            $thumb->save($dirImgArray[$key].$prefix.$data['name'].$fileExtends);
                                            break;
                                    }
                                }
                            }
                        }

                        // Supprime l'ancienne image
                        if(!empty($data['edit'])){
                            if(is_array($imgCollection)) {
                                $dirImgArray = $this->dirImgUploadCollection($imgCollection);
                                foreach($fetchConfig as $key => $value) {
                                    if (file_exists($dirImgArray[$key] . $data['edit'])) {
                                        $makeFiles->removeFile($dirImgArray[$key], $data['edit']);
                                    }
                                }
                            }
                        }
                        //Supprime le fichier local
                        if(file_exists($dirImg.$data['name'].$fileExtends)){
                            $makeFiles->removeFile($dirImg,$data['name'].$fileExtends);
                        }else{
                            throw new Exception('file: '.$this->$img.' is not found');
                        }

                        return array('file'=>$data['name'].$fileExtends,'statut'=>$resultUpload['statut'],'notify'=>$resultUpload['notify'],'msg'=>$resultUpload['msg']);
                    }else{
                        //Supprime le fichier local
                        if(file_exists($dirImg.$this->$img)){
                            $makeFiles->removeFile($dirImg,$this->$img);
                        }else{
                            throw new Exception('file: '.$this->$img.' is not found');
                        }
                    }
                }else{
                    if(!empty($data['edit'])){
                        if(is_array($imgCollection)) {
                            $dirImgArray = $this->dirImgUploadCollection($imgCollection);
                            foreach($fetchConfig as $key => $value) {
                                if (file_exists($dirImgArray[$key] . $data['edit'])) {
                                    $makeFiles->removeFile($dirImgArray[$key], $data['edit']);
                                }
                            }
                        }
                    }
                    return array('file'=>null,'statut'=>$resultUpload['statut'],'notify'=>$resultUpload['notify'],'msg'=>$resultUpload['msg']);
                }
            }catch (Exception $e){
                magixglobal_model_system::magixlog('An error has occured :',$e);
            }
        }
    }

    /**
     * Remove img
     * @param $data
     * @param $imgCollection
     * @param bool $debug
     */
    public function setRemoveImage($data,$imgCollection,$debug = false){
        if($data['name']!= null){
            $makeFiles = new magixcjquery_files_makefiles();
            $fetchConfig = parent::fetchConfig(array('type'=>'config','context'=>'imgSize','attr_name'=>$data['attr_name'],'attr_size'=>$data['attr_size']));
            if(is_array($imgCollection)) {
                $dirImgArray = $this->dirImgUploadCollection($imgCollection);
                foreach($fetchConfig as $key => $value) {
                    if (file_exists($dirImgArray[$key] . $data['name'])) {
                        if($debug){
                            print $dirImgArray[$key] . $data['name'];
                        }else{
                            $makeFiles->removeFile($dirImgArray[$key], $data['name']);
                        }
                    }
                }
            }
        }
    }
    /* ##################################### Utility with Curl for External Web Service ##########################################*/
    /**
     * Prepare request Data with Curl (no files)
     * @param $data
     * @return mixed
     *
     $json = json_encode(array(
        'category'=>array(
            'id'  =>'16'
        )));
        print_r($json);
        print $this->webservice->setPreparePostData(array(
        'wsAuthKey' => $this->webservice->setWsAuthKey(),
        'method' => 'xml',
        'data' => $test,
        'customRequest' => 'DELETE',
        'debug' => false,
        'url' => 'http://www.mywebsite.tld/webservice/catalog/categories/'
        ));
     */
    public function setPrepareSendData($data){
        if($this->with_curl) {
            $curl_params = array();
            $encodedAuth = $data['wsAuthKey'];
            $generatedData = urlencode($data['data']);
            switch($data['method']){
                case 'json';
                    $headers = array("Authorization : Basic " . $encodedAuth,'Content-type: application/json','Accept: application/json');
                    break;
                case 'xml';
                    $headers = array("Authorization : Basic " . $encodedAuth,'Content-type: text/xml','Accept: text/xml');
                    break;
            }

            $options = array(
                CURLOPT_HEADER          => 0,
                CURLINFO_HEADER_OUT     => 1,                // For debugging
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_NOBODY          => false,
                CURLOPT_URL             => $data['url'],
                CURLOPT_HTTPAUTH        => CURLAUTH_BASIC,
                CURLOPT_USERPWD         => $encodedAuth,
                CURLOPT_HTTPHEADER      => $headers,
                //CURLOPT_POST          => true,
                //CURLOPT_FORBID_REUSE  => 1,
                //CURLOPT_FRESH_CONNECT =>1,
                CURLOPT_CONNECTTIMEOUT  => 300,
                CURLOPT_CUSTOMREQUEST   => $data['customRequest'],
                CURLOPT_POSTFIELDS      => $generatedData
                //CURLOPT_SAFE_UPLOAD     => false*/
            );
            $ch = curl_init();
            curl_setopt_array($ch, $options);
            $response = curl_exec($ch);
            $curlInfo = curl_getinfo($ch);
            curl_close($ch);
            // Data
            /*$header = trim(substr($response, 0, $curlInfo['header_size']));
            $body = substr($response, $curlInfo['header_size']);

            print_r(array('status' => $curlInfo['http_code'], 'header' => $header, 'data' => json_decode($body)));*/
            if(array_key_exists('debug',$data) && $data['debug']){
                var_dump($curlInfo);
                var_dump($response);
            }
            if ($response) {
                return $response;
            }
        }
    }

    /**
     * @param $data
     * @return mixed
     *
     print $this->webservice->setPrepareGet(array(
        'wsAuthKey' => $this->webservice->setWsAuthKey(),
        'method' => 'xml',
        'debug' => false,
        'url' => 'http://www.mywebsite.tld/webservice/catalog/categories/'
    ));
     */
    public function setPrepareGet($data){
        try {
            if($this->with_curl) {
                $curl_params = array();
                $encodedAuth = $data['wsAuthKey'];
                switch($data['method']){
                    case 'json';
                        $headers = array("Authorization : Basic " . $encodedAuth,'Content-type: application/json','Accept: application/json');
                        break;
                    case 'xml';
                        $headers = array("Authorization : Basic " . $encodedAuth,'Content-type: text/xml','Accept: text/xml');
                        break;
                }
                $options = array(
                    CURLOPT_RETURNTRANSFER => true,
                    CURLINFO_HEADER_OUT => true,
                    CURLOPT_URL => $data['url'],
                    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                    CURLOPT_USERPWD => $encodedAuth,
                    CURLOPT_HTTPHEADER => $headers,
                    CURLOPT_CUSTOMREQUEST => "GET"
                );

                $ch = curl_init();
                curl_setopt_array($ch, $options);

                $response = curl_exec($ch);
                $curlInfo = curl_getinfo($ch);
                curl_close($ch);
                if (array_key_exists('debug', $data) && $data['debug']) {
                    var_dump($curlInfo);
                    var_dump($response);
                }
                if ($curlInfo['http_code'] == '200') {
                    if ($response) {
                        return $response;
                    }
                }

            }
        }catch (Exception $e){
            magixglobal_model_system::magixlog('An error has occured :',$e);
        }
    }

    /**
     * Prepare post Img with Curl (files only)
     * @param $data
     * @return mixed
         print $this->webservice->setPreparePostImg(array(
            'wsAuthKey' =>  $this->webservice->setWsAuthKey(),
            'url'       => 'http://www.website.tld/webservice/catalog/categories/3',
            'debug' => false,
        ));
     */
    public function setPreparePostImg($data){
        if($this->with_curl) {
            if (isset($_FILES)) {
                $ch = curl_init();

                $curl_params = array();
                $encodedAuth = $data['wsAuthKey'];

                $img = array(
                    'img' =>
                        '@' . $_FILES['img']['tmp_name']
                        . ';filename=' . $_FILES['img']['name']
                        . ';type=' . $_FILES['img']['type']
                );

                $options = array(
                    CURLOPT_HEADER          => 0,
                    CURLOPT_RETURNTRANSFER  => true,
                    CURLINFO_HEADER_OUT     => true,
                    CURLOPT_URL             => $data['url'],
                    CURLOPT_HTTPAUTH        => CURLAUTH_BASIC,
                    CURLOPT_USERPWD         => $encodedAuth,
                    CURLOPT_HTTPHEADER      => array("Authorization : Basic " . $encodedAuth/*,"Content-Type: multipart/form-data"*/),
                    CURLOPT_CUSTOMREQUEST   => "POST",
                    CURLOPT_POST            => true,
                    CURLOPT_POSTFIELDS      => $img
                    //CURLOPT_SAFE_UPLOAD   => false
                );
                $ch = curl_init();
                curl_setopt_array($ch, $options);
                $response = curl_exec($ch);
                $curlInfo = curl_getinfo($ch);
                curl_close($ch);
                if(array_key_exists('debug',$data) && $data['debug']){
                    var_dump($curlInfo);
                    var_dump($response);
                }
                if ($response) {
                    return $response;
                }
            }
        }
    }
}
?>