<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test extends MX_Controller {
	public $responses;
	public $token;
	public $keys;
	function __construct(){
		parent::__construct();
		$this->load->library('rest');
		$config =  array('server' => base_url());
		$this->rest->initialize($config);
		$this->load->model('global_model', 'GlobalMD');	
		$this->keys = CORE_KEY();
		$this->consumer_key = CONSUMER_KEY();
		$this->consumer_secret = CONSUMER_SECRET();
		$this->consumer_ttl = CONSUMER_TTL();
		$this->token = null;
	}
	private function install_token_to_db($param){
		try{
			$response = $this->mongo_db->insert('token', $param);
			return $response;
		}catch (Exception $e) {
            return null;
        }
	}
	public function index(){
		$param = array(
			'param' => json_encode(array(
				'username' => 'Reseller',
				'password' => '123123F',
			)),
		);
		$response = $this->rest->get('token/create',$param);
		// $DeCryptReponse = decrypt_key($response->data->responses,$this->keys);
		// var_dump(json_decode($DeCryptReponse,true));
		echo "<pre>";
		print_r($response);
		echo "</pre>";
		// var_dump(json_encode($param_Transfer));
	}

	
}
?>