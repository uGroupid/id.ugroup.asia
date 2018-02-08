<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
Class Token extends REST_Controller {
	public $responses;
	public $token;
	public $keys;
	function __construct(){
		parent::__construct();
		$this->load->model('global_model', 'GlobalMD');	
		$this->keys = CORE_KEY();
		$this->consumer_key = CONSUMER_KEY();
		$this->consumer_secret = CONSUMER_SECRET();
		$this->consumer_ttl = CONSUMER_TTL();
		$this->responses = $this->load_missing();
		$this->token = null;
		
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
	
	public function check_get(){
		
		$this->response($this->responses);
	}
	public function create_get(){
		
		if(isset($_GET)){
			if(!empty($_GET)){
				if(isset($_GET['param'])){
					if(!empty($_GET['param'])){
						$this->token = $this->GlobalMD->create_token();
						$this->responses = array(
							'data' => array(
								'message' => $this->GlobalMD->msg(1000),
								'responses' => array(
									'token' => $this->token,
									'token_validate' => $this->GlobalMD->validate($this->token),
									'token_decode' => $this->GlobalMD->decode($this->token),
								),
							),
						);
					}
				}
			}
		}
		$this->response($this->responses);
	}
	public function info_get(){
		
		$this->response($this->responses);
	}

	
	
}
?>