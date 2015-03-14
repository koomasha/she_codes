<?php
	class token_dal{

		private $db;
		
		public function __construct() {    
			$this->db = new db_session();
		}
		

		public function verify_token($token)
		{
			$query = "select * from token where tokenunq = ? and tokenactive = 1 and tokentimemod > DATE_SUB(NOW(),INTERVAL 120 MINUTE)";
			$params = array($token);	
			$data = db_command::ExecuteQuery($this->db, $query, $params);
			if(!empty($data))
			{
				$usrid = $data[0]['tokenusrid'];
				$query = "update token set tokentimemod = now() where tokenid = ?";
				$params = array($data[0]['tokenid']);	
				db_command::ExecuteNonQuery($this->db, $query, $params);
			}
			else
			{
				$query = "update token set tokenactive = 0 where tokenunq = ?";
				$params = array($token);	
				$affected_rows = db_command::ExecuteNonQuery($this->db, $query, $params);
				if($affected_rows > 0)
					throw new api_exception('',-205);
				else
					throw new api_exception('',-203);
			}
			return $usrid;
		}
		
				
		public 	function create_token($usrid)
		{
			$ip = $browser = '';
			if(isset($_SERVER['REMOTE_ADDR']))
				$ip = $_SERVER['REMOTE_ADDR'];
			if(isset($_SERVER['HTTP_USER_AGENT']))
				$browser = $_SERVER['HTTP_USER_AGENT'] ;
			$query ="update token set tokenactive = 0 where tokenusrid = ?";
			//$query ="delete from token where tokenusrid = ?";
			db_command::ExecuteNonQuery($this->db, $query, array($usrid));	
			$query = "insert into token(tokenunq,tokenusrid,tokenip,tokentimemod,tokenbrowser) values(uuid(),?,?,now(),?)";
			$params = array($usrid,$ip,$browser);	
			$tokenid = db_command::PerformInsert($this->db, $query, $params);
			$query = "select * from token where tokenid = ?";
			$params = array($tokenid);	
			$data = db_command::ExecuteQuery($this->db, $query, $params);
			return $data[0]['tokenunq'];
		}	
		
		public function discard_token($token)
		{
			$query = "select * from token where tokenunq = ? and tokenactive = 1";
			$params = array($token);	
			$data = db_command::ExecuteQuery($this->db, $query, $params);
			if(!empty($data))
			{
				$query = "update token set tokenactive = 0 where tokenid = ?";
				$params = array($data[0]['tokenid']);	
				db_command::ExecuteNonQuery($this->db, $query, $params);
			}
			return $data;
		}
		
		public function get_usrid_by_token($token)
		{
			$query = "select tokenusrid from token where tokenunq like ?";
			$data = db_command::ExecuteQuery($this->db, $query, array($token));
			return $data[0]['tokenusrid'];
		}
	}
?>