<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Contact extends REST_Controller {
	public $responses;
	public $access_token;
	public $uid;
	public $keys;
	public $token_validate;
	public $contact_id;
	public $contact_default;
	public $contact_owner;
	public $contact_tech;
	public $contact_admin;
	public $contact_bill;
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
		$this->responses = $this->load_missing();
		$this->contact_id = null;
		$this->uid = null;
		$this->contact_default = null;
		$this->contact_owner = null;
		$this->contact_tech = null;
		$this->contact_admin = null;
		$this->contact_bill = null;
		$this->access_token = false;
		$this->token_validate = 'false';
	}
	public function index_get(){
		$this->responses = array($this->GlobalMD->msg());
		$this->response($this->responses);
	}
	public function index_post(){
		$this->responses =  array($this->GlobalMD->msg());
		$this->response($this->responses);
	}
	public function load_missing(){
		return $this->responses = $this->GlobalMD->msg(2001);
		
	}
	private function load_error_expired_token(){
		return array('msg' => $this->GlobalMD->msg(2201));
	}
	private function get_id_access_token($access_token){
		$user = $this->GlobalMD->decode($this->access_token);
		if(isset($user->uid)){
			if(!empty($user->uid)){
				return $this->uid = $user->uid;
			}
		}
	}
	public function suppend(){
		
	}
	public function remove(){
		
	}
	public function add(){
		
	}
	public function info_get(){
		if(isset($_GET)){
			if(!empty($_GET)){
				if(isset($_GET['access_token'])){
					if(!empty($_GET['access_token'])){
						$this->access_token = $_GET['access_token'];
						$check_access_token = $this->GlobalMD->validate($this->access_token);
						if($check_access_token==true){
							if(isset($_GET['param'])){
								if(!empty($_GET['param'])){
									$params = $_GET['param'];
									$x = json_decode($params);
									if(isset($x->contact_id)){
										if(!empty($x->contact_id)){
											$this->contact_id = $x->contact_id;
											$this->access_token = $_GET['access_token'];
											$this->uid = $this->get_id_access_token($this->access_token);
											$this->responses = array(
											'responses' => array(
												'message' => $this->GlobalMD->msg(1000),
												'result' => array(
													'data' => array(
														'access_token'=> $this->access_token,
														'response' => $this->GlobalMD->info_contact($this->contact_id,$this->uid),
													),
												),
											),
										);
										}else{
											$this->responses = $this->GlobalMD->msg(2003);
										}
									}else{
										$this->responses = $this->GlobalMD->msg(2005);
									}
								}else{
									$this->responses = $this->GlobalMD->msg(2003);
								}
							}else{
								$this->responses = $this->GlobalMD->msg(2001);
							}
						}else{
							$this->responses = $this->load_error_expired_token();
						}
					}else{
						$this->responses = $this->GlobalMD->msg(2200);
					}
				}else{
					$this->responses = $this->GlobalMD->msg(2200);
				}
			}
		}
		$this->response($this->responses);
	}
	
	
	
	
}
?>