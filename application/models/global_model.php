<?php
class Global_model extends CI_Model{
		function __construct(){
			parent::__construct();
			
	}
	public function query_global($sql){
     $query = $this->db->query($sql);
          return $query->result_array();
	}

	public function responses_msg($code){
		if(!isset($code)){
			$code = 00;
		}
		$this->db->select('*');
		$this->db->where('code',$code);
		$this->db->from('conf_responses');
		$query = $this->db->get();
		return $query->result_array();
	}
	
/////////////////// End Noi dung ////////////

}
?>