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
	//////////////////////////////////
	function __construct(){
		parent::__construct();
		$this->load->model('global_model', 'GlobalMD');	
		$this->consumer_key = CONSUMER_KEY();
		$this->consumer_secret = CONSUMER_SECRET();
		$this->consumer_ttl = CONSUMER_TTL();
		
		// $this->load->controller('testcase','testcase_controller');
		if(!empty($_GET['token'])){
			$token = $_GET['token'];
			$this->token = $token;
		}else{
			$response = array($this->load_error());
			$this->response($response);
		}
	}
	private function load_error(){
		return $this->GlobalMD->responses_msg(00);
	}
	public function index_get(){
		// $this->token = $this->testcase_controller->index();
		$response = array('token'=>$this->token,);
		$this->response($response);
	}
	
	
	
}
?>