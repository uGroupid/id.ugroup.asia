<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Token extends REST_Controller {
	function __construct(){
		parent::__construct();
		$this->consumer_key = CONSUMER_KEY();
		$this->consumer_secret = CONSUMER_SECRET();
		$this->consumer_ttl = CONSUMER_TTL();
		$this->load->model('global_model', 'GlobalMD');	
	}
	public function index_get(){
		$response = array('');
		if(isset($_GET['params'])){

		}else{
			$response = array($this->GlobalMD->responses_msg(00))
		}
		$this->response($response);
		

	}
	public function check_get(){
		$response = array('');
		$this->response($response);
	}
	public function create_get(){
		$response = array('');
		$this->response($response);
	}
	public function info_get(){
		$response = array('');
		$this->response($response);
	}

	private function validate($token)
    {
        try {
            $decodeToken = $this->jwt->decode($token, $this->consumer_secret);
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
	private function decode($token)
    {
        try{
            $decodeToken = $this->jwt->decode($token, $this->consumer_secret);
            return $decodeToken;
        }catch (Exception $e) {
            return false;
        }
    }
	private function Initialize_Token($uid,$param){
       $token = $this->jwt->encode(array(
            'key' => $this->consumer_secret,
            'uid' => $uid,
            'param' => $param,
            'expires_in' => date(DATE_ISO8601, strtotime("now")),
            'ttl' => $this->consumer_ttl,
        ), $this->consumer_secret);
        return $token;
	}
	
}
?>