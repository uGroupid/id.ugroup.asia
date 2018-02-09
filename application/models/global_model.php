<?php
class Global_model extends CI_Model{ 
	public $token;
	public $uid;
	public $storage;
	public $keys;
	function __construct(){
		parent::__construct();	
		$this->load->library('JWT');
		$this->keys = CORE_KEY();
		$this->consumer_key = CONSUMER_KEY();
		$this->consumer_secret = CONSUMER_SECRET();
		$this->consumer_ttl = CONSUMER_TTL();
		$this->token = null;
		$this->storage = null;
		$this->uid = null;
	}
	public function query_global($sql){
     $query = $this->db->query($sql);
          return $query->result_array();
	} 
	
	public function load_log($data){
		$this->mongo_db->insert('log_api',$data);
	}
	private function responses_msg($code=00){
		$code = "$code";
		$response =  $this->mongo_db->select('code,message')->where(array('code' => "$code"))->get('conf_responses');
		return $response;
	}
	
	public function msg($code=00){
		$msg = $this->responses_msg($code);
		if(!empty($msg)){
			return $msg;
		}else{
			return  $this->responses_msg(2000);
		}
	}
	
	public function create_token($param=null){
		if(isset($param)){
			if(!empty($param)){
				// $this->storage = $param['storage_pub'];
				// $this->uid = $param['storage_pub'];
				if($this->uid == null || $this->storage == null){
					return $this->Initialize_Token($this->uid,$this->storage);
				}else{
					return $this->Initialize_Token($this->uid,$this->storage);
				}
			}else{
				return $this->Initialize_Token($this->uid,$this->storage);
			}
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
        }catch (Exception $e) {
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
		$param = array(
            'key' => $this->consumer_secret,
            'uid' => $this->uid,
            'param' => $this->storage,
            'expires_in' => date(DATE_ISO8601, strtotime("now")+(int)$this->consumer_ttl),
            'ttl' => $this->consumer_ttl,
            'created' => date(DATE_ISO8601, strtotime("now")),
        );
		$result_insert = $this->install_token_to_db($param);
		if($result_insert==true){
			 $this->token = $this->jwt->encode(array(
				'key' => $this->consumer_secret,
				'id_token' => $result_insert->{'$id'},
				'uid' => $this->uid,
				'param' => $this->storage, 
				'expires_in' => date(DATE_ISO8601, strtotime("now")+(int)$this->consumer_ttl),
				'ttl' => $this->consumer_ttl,
			), $this->consumer_secret);
			return $this->token;
		}else{
			return $this->token;
		}
	}
	private function install_token_to_db($param){
		try{
			$response = $this->mongo_db->insert('token', $param);
			return $response;
		}catch (Exception $e) {
            return null;
        }
	}
	

}
?>