<?php
class frontend_model_webservice extends frontend_db_webservice{
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

    /**
     * @return string
     */
    public function getContentType(){
        return 'text/xml';
    }

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

        if (isset($_SERVER['PHP_AUTH_USER'])) {
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
     * Prepare post Data with Curl (no files)
     * @param $data
     * @return mixed
     */
    public function setPreparePostData($data){
        if($this->with_curl) {
            $curl_params = array();
            $encodedAuth = $data['wsAuthKey'];
            $generated_xml = urlencode($data['request']);
            $options = array(
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLINFO_HEADER_OUT => true,
                CURLOPT_URL => $data['url'],
                CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                CURLOPT_USERPWD => $encodedAuth,
                CURLOPT_HTTPHEADER => array("Authorization : Basic " . $encodedAuth/*"application/x-www-form-urlencoded","Content-Type: text/xml; charset=UTF-8"*/),
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $data['method'] . "=" . $generated_xml/*,
            CURLOPT_SAFE_UPLOAD     => false*/
            );
            $ch = curl_init();
            curl_setopt_array($ch, $options);
            $response = curl_exec($ch);
            $curlInfo = curl_getinfo($ch);
            curl_close($ch);
            if ($response) {
                return $response;
            }
        }
    }

    /**
     * Prepare post Img with Curl (files only)
     * @param $data
     * @return mixed
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
                    CURLOPT_HEADER => 0,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLINFO_HEADER_OUT => true,
                    CURLOPT_URL => $data['url'],
                    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                    CURLOPT_USERPWD => $encodedAuth,
                    CURLOPT_HTTPHEADER => array("Authorization : Basic " . $encodedAuth/*,"Content-Type: multipart/form-data"*/),
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $img/*,
            CURLOPT_SAFE_UPLOAD     => false*/
                );
                $ch = curl_init();
                curl_setopt_array($ch, $options);
                $response = curl_exec($ch);
                $curlInfo = curl_getinfo($ch);
                curl_close($ch);
                if ($response) {
                    return $response;
                }

                //print '<pre>';
                //print_r($data['request']);
                //print_r($curlInfo);
                //print '</pre>';
            }
        }
    }
}
?>