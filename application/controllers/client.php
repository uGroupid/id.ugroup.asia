<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Client extends REST_Controller {
	public $token;
	public $username ;
	public $passwords;
	public $email;
	/////////////////////////////////
	public $street;
	public $zip;
	public $city;
	public $state;
	public $country;
	public $telephone;
	public $mobile;
	public $fax;
	//////////////////////////////////
	public $company_name;
	public $vat_id;
	public $customer_no;
	public $contact_name;
	public $language;
	public $usertheme;
	public $notes;
	public $created_at;
	public $response;
	//////////////////////////////////
	function __construct(){
		parent::__construct();
		$this->load->model('global_model', 'GlobalMD');	
		$this->load->controller('core_service','core_controller');
		$this->consumer_key = CONSUMER_KEY();
		$this->consumer_secret = CONSUMER_SECRET();
		$this->consumer_ttl = CONSUMER_TTL();
		$this->response = array('');
		if(!empty($_GET['token'])){
			$check_token = $this->core_controller->validate($_GET['token']);
			if($check_token==true || !empty($check_token)){
				$this->token =  $_GET['token'];
				return $this->token;
			}else{
				$this->response = array($this->load_error_expired_token());
				$this->response($this->response);
			}
		}else{
			$this->response = array($this->load_error());
			$this->response($this->response);
		}
		
	}
	private function load_error_expired_token(){
		return array('msg' => $this->GlobalMD->msg(2201));
	}
	private function load_error(){
		return array('msg' => $this->GlobalMD->msg(1020));
	}
	
	public function index_get(){
		$uid = "123";
		$param = array(
			'full_name' => 'handesk',
			'age' => 26,
			'addr' => '132/62 Cầu Diễn - Minh Khai - Quận Bắc Từ Liêm - Hà Nội ',
			'phone' => '093-233-7122',
			'auth',
		);
		$param_json = json_encode($param,true);
		// $this->token = $this->core_controller->create_token($uid,$param_json);
		$response = array('token'=>$this->token,);
		$this->response($response);
	}
	
	
	
}
?>