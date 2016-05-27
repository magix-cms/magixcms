<?php
class frontend_model_webservice{
    public function __construct()
    {
        if (function_exists("curl_init")) {
            $this->with_curl = TRUE;
        } else {
            $this->with_curl = FALSE;
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
    public function preparePostData($data){
        $curl_params = array();
        $encodedAuth = $data['wsAuthKey'];
        $generated_xml = urlencode($data['request']);
        $options = array(
            CURLOPT_HEADER          => 0,
            CURLOPT_RETURNTRANSFER  => true,
            CURLINFO_HEADER_OUT     => true,
            CURLOPT_URL             => $data['url'],
            CURLOPT_HTTPAUTH        => CURLAUTH_BASIC,
            CURLOPT_USERPWD         => $encodedAuth,
            CURLOPT_HTTPHEADER      => array("Authorization : Basic ".$encodedAuth/*"application/x-www-form-urlencoded","Content-Type: text/xml; charset=UTF-8"*/),
            CURLOPT_CUSTOMREQUEST   => "POST",
            CURLOPT_POSTFIELDS      => $data['method']."=".$generated_xml
        );
        $ch = curl_init();
        curl_setopt_array($ch,$options);
        $response = curl_exec($ch);
        $curlInfo = curl_getinfo($ch);
        curl_close ($ch);
        if($response){
            return $response;
        }
    }
}
?>