<?php 
	class users
	{
		public function get_active_users_by_rating()
		{
			global $user_dal;
			
			$this->check_pages_set();
			return $user_dal->get_active_users_by_rating($_POST['numofusrs'],$_POST['usrpage']);
		}
		
		public function search_user()
		{
			global $user_dal;
			global $result;
			$this->check_pages_set();
			if(!isset($_POST['searchstr']))
				throw new api_exception("searchstr",-104);
			$searchstr = trim($_POST['searchstr']);
			if(empty($searchstr))
				throw new api_exception("searchstr",-208);
			return $user_dal->search_user($searchstr,$_POST['numofusrs'],$_POST['usrpage']);
		}
		private function check_pages_set()
		{
			if(!(isset($_POST['numofusrs']) && isset($_POST['usrpage'])))
				throw new api_exception("numofusrs, usrpage",-104);
			$num_of_usrs = $_POST['numofusrs'];
			$page_number = $_POST['usrpage'];	
			if($page_number < 1)
				throw new api_exception("",-207);
			else if(!is_numeric($page_number) || !is_numeric($num_of_usrs))	
				throw new api_exception("page number, number of users",-208);
		}
		
		public function get_my_data()
		{
			global $token;
			global $user_dal;
			global $token_dal;
			$id = $token_dal->get_usrid_by_token($token);
			return $user_dal->get_user_by_id($id, $token);		
		}
		
		public function add_rating()
		{
			global $token;
			global $user_dal;
			global $token_dal;
			global $branch_dal;
		
			$invalid_parameters = '';
			
			if(isset($_POST['usrid']))
				$usrid = $_POST['usrid'];
			else
				$invalid_parameters = $invalid_parameters.' usrid,';
			if(isset($_POST['ratingpoints']))
				$ratingpoints = $_POST['ratingpoints'];
			else
				$invalid_parameters = $invalid_parameters.' ratingpoints,';
			if(isset($_POST['ratingremark']))
				$ratingcomment = $_POST['ratingremark'];
			else
				$invalid_parameters = $invalid_parameters.' ratingremark,';
			if(isset($_POST['ratingdate']))
			{
				$ratingdate = $_POST['ratingdate'];
				$date = new DateTime("@$ratingdate");
				$ratingdate = $date->format('Y-m-d H:i:s');
			}
			else
			{
				$ratingdate = new DateTime();
				$ratingdate = $ratingdate->format('Y-m-d H:i:s');
			}
			if(isset($_POST['branchid']))
				$ratingbranchid = $_POST['branchid'];
			else
				$ratingbranchid = $branch_dal->get_default_branch_id();
			$usrblameid = $token_dal->get_usrid_by_token($token);

			if($invalid_parameters != '')	
				throw new api_exception('Invalid parameters: '.rtrim($invalid_parameters,','),-208);	
			else
				foreach($usrid as $id)
					$user_dal->add_rating_to_user($id,$usrblameid,$ratingpoints,$ratingcomment,$ratingdate,$ratingbranchid);	
		}
	}

?>