<?php
class Global_model extends CI_Model{ 
	public $access_token;
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
		$this->access_token = null;
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
		if(!empty($response)){
			return $response[0];
		}else{
			return $response;
		}
		
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
				try{
					$x = json_decode($param);
					if(isset($x->username)){
						if(!empty($x->username)){ 
							if(isset($x->password)){
								if(!empty($x->password)){ 
									$username = $x->username;
									$password = md5($x->password);
									$resultClients = $this->getUser($username,$password);
									if(!empty($resultClients)){
										$this->storage = $resultClients[0];
										$this->uid = $this->getObjectId($this->storage);
										return $this->Initialize_Token($this->uid,$this->storage);
									}else{
										return $this->msg(2201);
									}
								}else{
									return $this->msg(2003);
								}
							}else{
								return $this->msg(2005);
							}
						}else{
							return $this->msg(2003);
						}
					}else{
						return $this->msg(2005);
					}
				}catch (Exception $e) {
					return $this->msg(2400);
				}
			}else{
				return $this->msg(2001);
			}
		}else{
			return $this->msg(2000);
		}
	}
	private function getUser($username=null,$password=null){
		try{
			$response = $this->mongo_db->select(array('username','name','code','contact_defaults','contact_owner','contact_bill','contact_tech','contact_admin','contact_moderator','balancer','status','id_rell'))->where(array('username'=>$username,'passwords'=>$password))->get('users');
			return $response;
		}catch (Exception $e) {
            return null;
        }
	}
	public function validate($token_pub)
    {
        try {
			$this->access_token = $token_pub;
            $decodeToken = $this->jwt->decode($this->access_token, $this->consumer_secret);
            $ttl_time = strtotime($decodeToken->expires_in);
            $now_time = strtotime(date(DATE_ISO8601, strtotime("now")));
            if(($now_time - $ttl_time) > $decodeToken->ttl) {
				 return false;
            } else {
                return true;
            }
        }catch(Exception $e) {
            return false;
        }
    }
	public function decode($token_pub)
    {
        try{
			$this->access_token = $token_pub;
            $decodeToken = $this->jwt->decode($this->access_token, $this->consumer_secret);
            return $decodeToken;
        }catch (Exception $e) {
            return false;
        }
    }
	private function getObjectId($param) {
		return (string)$param["_id"];
	}
	private function Initialize_Token($uid=null,$storage=null){
		$param_log = array(
            'key' => $this->consumer_secret,
            'uid' => $uid,
            'param' => $storage,
            'expires_in' => date(DATE_ISO8601, strtotime("now")+(int)$this->consumer_ttl),
            'ttl' => $this->consumer_ttl,
            'created' => date(DATE_ISO8601, strtotime("now")),
        );
		$result_insert = $this->install_token_to_db($param_log);
		if($result_insert==true){
			 $this->access_token = $this->jwt->encode(array(
				'key' => $this->consumer_secret,
				'id_token' => $result_insert->{'$id'},
				'uid' => $uid,
				'param' => $storage, 
				'expires_in' => date(DATE_ISO8601, strtotime("now")+(int)$this->consumer_ttl),
				'ttl' => $this->consumer_ttl,
			), $this->consumer_secret);
			return $this->access_token;
		}else{
			return $this->access_token;
		}
	}
	public function info_contact($contact_id=null,$id_users=null){
		try{
			if(isset($contact_id) || isset($id_users)){
				if(!empty($contact_id) || !empty($id_users)){
					$response = $this->mongo_db->get_where('contacts', array('_id' => new \MongoId($contact_id), 'id_users' => new \MongoId($id_users)));
					if(!empty($response)){
						return $response[0];
					}else{
						 return $this->msg(2303);
					}
				}else{
					 return $this->msg(2003);
				}
			}else{
				 return $this->msg(2005);
			}
			
		}catch (Exception $e) {
            return $this->msg(2005);
        }
	}
	private function install_token_to_db($param){
		try{
			$response = $this->mongo_db->insert('access_token', $param);
			return $response;
		}catch (Exception $e) {
            return null;
        }
	}
	

}
?>