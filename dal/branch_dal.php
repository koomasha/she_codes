<?php
	class branch_dal{

		private $db;
		
		public function __construct() {    
			$this->db = new db_session();
		}
		
		public function get_default_branch_id()
		{
			$query = "select branchid from branch where branchid = 1";
			$data = db_command::ExecuteQuery($this->db, $query, array());	
			return $data[0]['branchid'];
		}
		
		public function get_branches()
		{
			$query = "select * from branch";
			return db_command::ExecuteQuery($this->db, $query, array());	
		}
	}
?>