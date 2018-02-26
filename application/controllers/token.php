<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
Class Token extends REST_Controller {
	public $responses;
	public $access_token;
	public $keys;
	public $token_validate;
	function __construct(){
		parent::__construct();
		$this->load->model('global_model', 'GlobalMD');	
		$this->keys = CORE_KEY();
		$this->consumer_key = CONSUMER_KEY();
		$this->consumer_secret = CONSUMER_SECRET();
		$this->consumer_ttl = CONSUMER_TTL();
		$this->responses = $this->load_missing();
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
	public function check_get(){
		if(isset($_GET)){
			if(!empty($_GET)){
				if(isset($_GET['param'])){
					if(!empty($_GET['param'])){
						$params = $_GET['param'];
						$x = json_decode($params);
						if(isset($x->access_token)){
							if(!empty($x->access_token)){
								$this->token_validate = $this->GlobalMD->validate($x->access_token);
								if($this->token_validate==true){
									$this->token_validate = 'true';
								}else{
									$this->token_validate = 'false';
								}
							}else{
								$this->access_token = $this->GlobalMD->msg(2005);
							}
						}else{
							$this->access_token = $this->GlobalMD->msg(2003);
						}
						$this->responses = array(
							'responses' => array(
								'message' => $this->GlobalMD->msg(1000),
								'result' => array(
									'data' => array(
										'token_validate'=> $this->token_validate,
										'access_token'=> $x->access_token,
										
									),
								),
							),
						);
					}else{
						$this->responses = $this->GlobalMD->msg(2200);
					}
				}
			}
		}
		$this->response($this->responses);
	}
	
	public function create_get(){
		if(isset($_GET)){
			if(!empty($_GET)){
				if(isset($_GET['param'])){
					if(!empty($_GET['param'])){
						$params = $_GET['param'];
						$x = json_decode($params);
						if(isset($x->username) || isset($x->password)){
							$this->access_token = $this->GlobalMD->create_token($params);
							
						}else{
							$this->access_token = $this->GlobalMD->msg(2001);
						}
						$this->responses = array(
							'responses' => array(
								'message' => $this->GlobalMD->msg(1000),
								'result' => array(
									'data' => array(
										'access_token'=> $this->access_token,
									),
								),
							),
						);
					}else{
						$this->responses = $this->GlobalMD->msg(2003);
					}
				}
			}
		}
		$this->response($this->responses);
	}

	public function info_get(){
		if(isset($_GET)){
			if(!empty($_GET)){
				if(isset($_GET['param'])){
					if(!empty($_GET['param'])){
						$params = $_GET['param'];
						$x = json_decode($params);
						if(isset($x->access_token)){
							if(!empty($x->access_token)){
								$this->token_validate = $this->GlobalMD->validate($x->access_token);
								if($this->token_validate==true){
									$this->access_token = $this->GlobalMD->decode($x->access_token);
								}else{
									$this->access_token = $this->GlobalMD->msg(2303);
								}
							}else{
								$this->access_token = $this->GlobalMD->msg(2005);
							}
						}else{
							$this->access_token = $this->GlobalMD->msg(2003);
						}
						$this->responses = array(
							'responses' => array(
								'message' => $this->GlobalMD->msg(1000),
								'result' => array(
									'data' => array(
										'params'=> $x,
										'token_validate'=> $this->token_validate,
										'access_token_info'=> $this->access_token,
										
									),
								),
							),
						);
					}else{
						$this->responses = $this->GlobalMD->msg(2200);
					}
				}
			}
		}
		$this->response($this->responses);
	}

	
	
}
?>