ore<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH .'/libraries/ISPConfig_Controller.php';
class Core_service extends MX_Controller {
	public $token;
	public $uid;
	public $storage;
	function __construct(){
		parent::__construct();
		$this->consumer_key = CONSUMER_KEY();
		$this->consumer_secret = CONSUMER_SECRET();
		$this->consumer_ttl = CONSUMER_TTL();
	}
	public function create_token($uid_pub=null,$storage_pub=null){
		$this->storage = $storage_pub;
	    $this->uid = $uid_pub;
		if($this->uid == null || $this->storage == null){
			return $this->Initialize_Token($this->uid,$this->storage);
		}else{
			return $this->Initialize_Token($this->uid,$this->storage);
		}
	}
	public function validate($token_pub)
    {
        try {
			$this->token = $token_pub;
            $decodeToken = $this->jwt->decode($this->token, $this->consumer_secret);
            $ttl_time = strtotime($decodeToken->expires_in);
            $now_time = strtotime(date(DATE_ISO8601, strtotime("now")));
            if(($now_time - $ttl_time) > $decodeToken->ttl) {
				 return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
	public function decode($token_pub)
    {
        try{
			$this->token = $token_pub;
            $decodeToken = $this->jwt->decode($this->token, $this->consumer_secret);
            return $decodeToken;
        }catch (Exception $e) {
            return false;
        }
    }
	private function Initialize_Token(){
	 
	   
       $this->token = $this->jwt->encode(array(
            'key' => $this->consumer_secret,
            'uid' => $this->uid,
            'param' => $this->storage,
            'expires_in' => date(DATE_ISO8601, strtotime("now")),
            'ttl' => $this->consumer_ttl,
        ), $this->consumer_secret);
        return $this->token;
	}
		
	
}

?>