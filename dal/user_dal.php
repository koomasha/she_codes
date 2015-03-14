<?php
	class user_dal{

		private $db;
		
		public function __construct() {    
			$this->db = new db_session();
		}
		
		public function get_user_by_email($email)
		{
			$query = "select * from usr inner join usrstatus on usrstatusid = usrusrstatusid where usreml = ?";
			$params = array($email);	
			$data = db_command::ExecuteQuery($db, $query, $params);
			return $data;
		}
		public function get_user_by_fbid($fbid)
		{
			$query = "select * from usr inner join usrstatus on usrstatusid = usrusrstatusid where usrfbid = ?";
			$params = array($fbid);	
			$data = db_command::ExecuteQuery($this->db, $query, $params);
			return $data;
		}
		
		public function update_user_email($email,$usrid)
		{
			$query = 'update usr set usreml = ? where usrid = ?';
			$params = array($email,$usrid);
			db_command::ExecuteNonQuery($this->db, $query, $params);
		}
		
		public function update_user_fbid($fbid,$imgurl,$usrid)
		{
			$query = "update usr set usrfbid = ?, usrimgurl = ? where usrid = ?";
			$params = array($usrfbid,$usrimgurl,$usrid);	
			db_command::ExecuteNonQuery($this->db, $query, $params);
		}
		
		public 	function create_new_user($usrfbid,$usreml,$usrpwrd,$usrphone,$usrfirstname,$usrlastname,$usrimgurl)
		{
			$query = "insert into usr(usrfbid,usreml,usrpwrd,usrphone,usrusrstatusid,usrfirstname,usrlastname,usrimgurl,usrcreateddate) values(?,?,?,?,?,?,?,?,now())";
			$params = array($usrfbid,$usreml,$usrpwrd,$usrphone,2,$usrfirstname,$usrlastname,$usrimgurl);	
			$usrid = db_command::PerformInsert($this->db, $query, $params);	
			$query = "insert into rating(ratingusrid) values(?)";
			$params = array($usrid);	
			db_command::PerformInsert($this->db, $query, $params);
			return $usrid;
		}
		

		public function get_active_users_by_rating($numofusrs,$usrpage)
		{	
			$query = "select usrid,usrfbid,usrfirstname,usrlastname,usrimgurl,usrstatusname,ifnull(sum(ratingpoints),0) as usrrating 
					from usr left join rating on usrid = ratingusrid  inner join usrstatus on usrusrstatusid = usrstatusid 
					group by usrid,usrfbid,usrfirstname,usrlastname,usrimgurl,usrstatusname 
					order by usrrating desc,usrfirstname, usrlastname limit ";
			return $this->get_usrs_with_paging($query, array(),$numofusrs,$usrpage);
		}
		
		public function search_user($searchstr,$numofusrs,$usrpage)
		{
			$searchstr = $searchstr;
			$and="";
			$where = "";
			$tags = explode(' ',$searchstr);
			$params = array();
			foreach($tags as $key)
			{
				if(!empty($key))
				{
					$where .= $and."  lower(concat(' ',usreml ,' ',usrfirstname, ' ',usrlastname)) like lower(concat('% ',? ,'%')) ";
					array_push($params,$key);
					$and=" and ";
				}
			}			
			$query = "select usrid,usrfbid,usrfirstname,usrlastname,usrimgurl,usrstatusname,ifnull(sum(ratingpoints),0) as usrrating 
				from usr left join rating on usrid = ratingusrid inner join usrstatus on usrusrstatusid = usrstatusid 
				where ".$where."
				group by usrid,usrfbid,usrfirstname,usrlastname,usrimgurl,usrstatusname 
				order by usrrating desc, usrfirstname asc, usrlastname asc limit ";
			return $this->get_usrs_with_paging($query,$params,$numofusrs,$usrpage);	
		}
		
		public function get_usrs_with_paging($query, $params,$numofusrs,$page_number)
		{
			$result = array();
			$offset = ($page_number -1)*$numofusrs;
			$numofusrs++;
			$query = $query.$offset.",".$numofusrs;
			$data = db_command::ExecuteQuery($this->db, $query, $params);		
			$result['moredata'] = 0;
			if(count($data) == $numofusrs)
			{
				$result['moredata'] = 1;
				array_pop($data);
			}
			$result['usrs'] = $data;
			return $result;	
		}
		
		public function get_user_by_id($id, $token)
		{
			$query = 'select usrid,usrfbid,usrfirstname,usrlastname,usrimgurl,(select usrstatusname from usrstatus where usrstatusid =usrusrstatusid) as usrstatusname,ifnull(sum(ratingpoints),0) as usrrating 
				from usr left join rating on usrid = ratingusrid 
				where usrid = ?';
			$data = db_command::ExecuteQuery($this->db, $query, array($id));	
			return array("usrs"=>$data);
		}
				
		public function add_rating_to_user($id,$usrblameid,$ratingpoints,$ratingcomment,$ratingdate,$ratingbranchid)
		{
			$query = 'insert into rating(ratingusrid,ratingblameusrid,ratingpoints,ratingcomment,ratingcreateddate,ratingbranchid) values(?,?,?,?,?,?)';
			$params = array($id,$usrblameid,$ratingpoints,$ratingcomment,$ratingdate,$ratingbranchid);	
			db_command::ExecuteQuery($this->db, $query, $params);	
		}
	}
?>