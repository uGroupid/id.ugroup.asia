<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
Class Token extends REST_Controller {
	public $responses;
	public $token;
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
		$this->token = false;
		$this->token_validate = false;
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
						if(isset($x->token)){
							if(!empty($x->token)){
								$this->token_validate = $this->GlobalMD->validate($x->token);
								if($this->token_validate==true){
									$this->token = $this->token_validate;
								}else{
									$this->token = $this->GlobalMD->msg(2303);
								}
							}else{
								$this->token = $this->GlobalMD->msg(2005);
							}
						}else{
							$this->token = $this->GlobalMD->msg(2003);
						}
						$this->responses = array(
							'responses' => array(
								'message' => $this->GlobalMD->msg(1000),
								'result' => array(
									'data' => array(
										'token_validate'=> $this->token_validate,
										'access_token'=> $x->token,
										
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
							$this->token = $this->GlobalMD->create_token($params);
							
						}else{
							$this->token = $this->GlobalMD->msg(2001);
						}
						$this->responses = array(
							'responses' => array(
								'message' => $this->GlobalMD->msg(1000),
								'result' => array(
									'data' => array(
										'access_token'=> $this->token,
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
						if(isset($x->token)){
							if(!empty($x->token)){
								$this->token_validate = $this->GlobalMD->validate($x->token);
								if($this->token_validate==true){
									$this->token = $this->GlobalMD->decode($x->token);
								}else{
									$this->token = $this->GlobalMD->msg(2303);
								}
							}else{
								$this->token = $this->GlobalMD->msg(2005);
							}
						}else{
							$this->token = $this->GlobalMD->msg(2003);
						}
						$this->responses = array(
							'responses' => array(
								'message' => $this->GlobalMD->msg(1000),
								'result' => array(
									'data' => array(
										'params'=> $x,
										'token_validate'=> $this->token_validate,
										'access_token_info'=> $this->token,
										
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