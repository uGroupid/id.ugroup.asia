<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test extends MX_Controller {
	public $responses;
	public $token;
	public $keys;
	function __construct(){
		parent::__construct();
		$this->load->library('rest');
		$config =  array('server' => 'http://id.ugroup.asia');
		$this->rest->initialize($config);
		$this->load->model('global_model', 'GlobalMD');	
		$this->keys = CORE_KEY();
		$this->consumer_key = CONSUMER_KEY();
		$this->consumer_secret = CONSUMER_SECRET();
		$this->consumer_ttl = CONSUMER_TTL();
		$this->token = null;
	}
	public function index(){
		// $code = ;
		// $response =  $this->mongo_db->select('code,message')->where(array('code' => "$code"))->get('conf_responses');
		// $response = $this->mongo_db->select(array('code', 'message'))->get('conf_responses');
		// echo base_url();
		$param_Transfer = array(
			'param' => json_encode(array('account' => 'VNP08R22',),true),
		);
		
		$response = $this->rest->get('/token/create',$param_Transfer);
		// $DeCryptReponse = decrypt_key($response->data->responses,$this->keys);
		// var_dump(json_decode($DeCryptReponse,true));
		var_dump(json_encode($response->data));
		// var_dump(json_encode($param_Transfer));
	}

	
}
?>