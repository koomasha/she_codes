<?php
	class log_dal{
		private $db;
		
		public function __construct() {    
			$this->db = new db_session();
		}
		
		public function insert_log($sevirity,$msg,$code,$class,$action,$usrid,$post)
		{							
			$query = "insert into log(logusrid,logclass,logaction,logmessage,logerrcode,logpost,logseverity) values(?,?,?,?,?,?,?)";
			$params = array($usrid,$class,$action,$msg,$code,$post,$sevirity);
			return db_command::PerformInsert($this->db, $query, $params);	
		}
		
	}
?>


