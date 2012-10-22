<?php
class LoginAPI {
    protected $data = array();
    
    const NON_EXISTENT = 0;
    const INACTIVE = 1;
    const INCORRECT_PASSWORD = 2;
    const OK = 3;
    const INCORRECT_FORMATTING = 4;
    const ERROR = 5;
    
    public function __construct($apilogin, $apikey, $login, $password) {
       $aIps=array('81.190.182.93', '83.21.176.72', '95.160.184.166');                     // dodaj swoje IP
        $time = time();
        
        $url = 'http://forum.php.pl/login_api.php?login=%s&password=%s&veri=%s&key=%s&apilogin=%s';
        $url = sprintf($url, $login, md5(self::clean($password)), $time, md5($apikey . $time), $apilogin);
        
        $contents = @file_get_contents($url);

        if ($contents && $data = @unserialize($contents)) {
            $this->data = $data;
            
            /* Mo¿na siê bawiæ */
        if(in_array($_SERVER['REMOTE_ADDR'], $aIps))
			  {
         		//var_dump($data);     die();
        }
        
        } else {
            throw new Exception('Cannot fetch login API data');
        }
    }
    
    public function getData() {
        return $this->data;
    }
    
    public function getLogin() {
        return $this->login;
    }
    
    public function getPassword() {
        return $this->password;
    }
    
    public function getCode() {
        return isset($this->data['code']) ? $this->data['code'] : 0;
    }
    
    public function getId() {
        return isset($this->data['id']) ? $this->data['id'] : 0;
    }
    
    public function getName() {
        return isset($this->data['name']) ? $this->data['name'] : '';
    }
    
    public function getEmail() {
        return isset($this->data['email']) ? $this->data['email'] : '';
    }
    
    public static function clean($sValue)  {
        if($sValue == "")
        return "";
    
        $sValue = str_replace( "&#032;", " ", stripslashes($sValue) );
    
        $sValue = str_replace( "&"                , "&amp;"            , $sValue);
        $sValue = str_replace( "<!--"            , "&#60;&#33;--"    , $sValue);
        $sValue = str_replace( "-->"            , "--&#62;"            , $sValue);
        $sValue = preg_replace( "/<script/i"    , "&#60;script"        , $sValue);
        $sValue = str_replace( ">"                , "&gt;"            , $sValue);
        $sValue = str_replace( "<"                , "&lt;"            , $sValue);
        $sValue = str_replace( '"'                , "&quot;"            , $sValue);
        $sValue = str_replace( "\n"                , "<br />"            , $sValue); // Convert literal newlines
        $sValue = str_replace( "$"                , "&#036;"            , $sValue);
        $sValue = str_replace( "\r"                , ""                , $sValue); // Remove literal carriage returns
        $sValue = str_replace( "!"                , "&#33;"            , $sValue);
        $sValue = str_replace( "'"                , "&#39;"            , $sValue); // IMPORTANT: It helps to increase sql query safety.
    
        // Ensure unicode chars are OK
    
        if (true) {
            $sValue = preg_replace("/&amp;#([0-9]+);/s", "&#\\1;", $sValue );
    
            //-----------------------------------------
            // Try and fix up HTML entities with missing ;
            //-----------------------------------------
    
            $sValue = preg_replace( "/&#(\d+?)([^\d;])/i", "&#\\1;\\2", $sValue );
        }
        
        return $sValue;
    }
}
