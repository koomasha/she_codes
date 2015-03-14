<?php
class login
{
		public function fb_login()
		{
			global $result;
			global $token_dal;
			global $user_dal;
			global $config;
			if(isset($_GET['uri']))
			{	
				session_start();
				$_SESSION['uri'] = $_GET['uri'];
				header("Location: https://www.facebook.com/dialog/oauth?client_id=".$config['fbappid']."&redirect_uri=".$config['my_domain']."login/fb_login");
			}
			
			else if(isset($_GET['code']))
			{	
				session_start();
				if(isset($_SESSION['uri']))
				{
					header("Location: ".$_SESSION['uri']."?code=".$_GET['code']);
				}
				$result = null;
			}
			else if(isset($_POST['fbcode']))
			{	
				$response = json_decode($this->fb_authorize($_POST['fbcode']));
				
				//Init FB data
				$usrfbid = $response->id;
				$usreml = $response->email;
				$usrfirstname = $response->first_name;
				$usrlastname = $response->last_name;
				$usrimgurl = "https://graph.facebook.com/".$usrfbid."/picture?type=normal";
				
				
				$data = $user_dal->get_user_by_fbid($usrfbid);
				if(!empty($data) && $data[0]['usrstatusauthorized'])
				{
					$usrid = $data[0]['usrid'];
					if($data[0]['usreml'] == $usrfbid)
						$user_dal->update_user_email($usreml,$usrid);
				}
				else if(empty($data))
				{
					$data = $user_dal->get_user_by_email($usreml);
					if(!empty($data) && $data[0]['usrstatusauthorized'])
					{
						$usrid = $data[0]['usrid'];
						$user_dal->update_user_fbid($usrfbid,$usrimgurl,$usrid );
					}
					else if(empty($data))
						$usrid = $user_dal->create_new_user($usrfbid,$usreml,'','',$usrfirstname,$usrlastname,$usrimgurl);
					else
						throw new api_exception($data[0]['usrstatusname'].'. '.$data[0]['usrstatusremark'],-303);
				}
				else
					throw new api_exception($data[0]['usrstatusname'].'. '.$data[0]['usrstatusremark'],-303);
				$token = $token_dal->create_token($usrid);
				$result['token'] = $token;
			}
			else
				throw new api_exception('fbcode',-208);	
			return null;	
		}
		
		
		public function fb_login_test()
		{
			global $result;
			global $token_dal;

			if(isset($_POST['fbid']))
			{
				
				$usrfbid = $_POST['fbid'];
				$db = new db_session();	
				$query = "select * from usr inner join usrstatus on usrstatusid = usrusrstatusid where usrfbid = ?";
				$params = array($usrfbid);	
				$data = db_command::ExecuteQuery($db, $query, $params);
				if(!empty($data))
				{
					$token = $token_dal->create_token($data[0]['usrid']);
					$result['token'] = $token;
				}
				else
					throw new api_exception("",-204);
			}
			else	
				throw new api_exception("fbid",-104);
		}
		
		public function logout()
		{
			global $token_dal;
			global $token;
			
			$data = $token_dal->discard_token($token);
			if(empty($data))
				throw new api_exception("",-203);
		}

		public function env()
		{
			global $config;			
			return $config['env'];
		}

		private function fb_authorize($code)
		{
			global $config;
			
			$url =  "https://graph.facebook.com/oauth/access_token?client_id=".$config['fbappid']."&redirect_uri=".$config['my_domain']."login/fb_login&client_secret=".$config['fbappsecret']."&code=".$code;
			$response = $this->http_call($url);
			$url =  "https://graph.facebook.com/me?".$response;
			$response = $this->http_call($url);
			return $response;
		}
		
		private function http_call($url)
		{
			$options = array(
				'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'GET',
				),
			);
			$context  = stream_context_create($options);
			return file_get_contents($url, false, $context);
		}
		
		
		
		
		/*
			1.get user data 
			2. check there is no usr with same eml
			3.1 if no usr
				3.1.1 create new user and get user id
				3.1.2 create new token
				3.1.3 return token
			3.2 else
				3.2.1 return error
		*/
/*		public function sign_up()
		{
			global $result;
			global $error;
			if(isset($_POST['usreml']) && isset($_POST['usrpwrd']))
			{
				$usreml = $_POST['usreml'];
				$usrpwrd = $_POST['usrpwrd'];
				$usrfirstname = '';
				$usrlastname = '';
				$usrphone ='';
				$usrimgurl = '';
				if(isset($_POST['usrfirstname']))
					$usrfirstname = $_POST['usrfirstname'];
				if(isset($_POST['usrlastname']))
					$usrlastname = $_POST['usrlastname'];
				if(isset($_POST['usrphone']))
					$usrphone = $_POST['usrphone'];
				if(isset($_POST['usrimgurl']))
					$usrimgurl = $_POST['usrimgurl'];		
				$db = new db_session();	
				$query = "select * from usr inner join usrstatus on usrstatusid = usrusrstatusid where usreml = ?";
				$params = array($usreml);	
				$data = db_command::ExecuteQuery($db, $query, $params);
				if(!empty($data))
				{
					$usr = $data[0];
					if(!$usr['usrstatusauthorized'])
						$result['error'][] = $usr['usrstatusname'].'. '.$usr['usrstatusremark'];
					else if($usr['usrfbid'] != null)
						$result['error'][] = $error['usr_have_fb'];
					else
						$result['error'][] = $error['usr_exist'];
				}
				else
				{
					$usrid = create_new_usr(null,$usreml,$usrpwrd,$usrphone,$usrfirstname,$usrlastname,$usrimgurl);
					$token = create_token($usrid);
					$result['token'] = $token;
				}	
			}
			else	
				$result['error'][] = $error['eml_pwrd_missing'];	
		}
			
		/*
			1.get usreml and usrpwrd
			2.find active and authorized user 
			2.1 if exist
				2.1.1 create new token
				2.1.2 return token
			2.2 else
				2.2.1 return error
		*/
	/*	public function login()
		{
			global $result;
			global $error;
			
			if(isset($_POST['usreml']) && isset($_POST['usrpwrd']))
			{
				$usreml = $_POST['usreml'];
				$usrpwrd = $_POST['usrpwrd'];
				$db = new db_session();	
				$query = "select * from usr inner join usrstatus on usrstatusid = usrusrstatusid where usreml = ? and usrpwrd = ? ";
				$params = array($usreml,$usrpwrd);	
				$data = db_command::ExecuteQuery($db, $query, $params);
				if(!empty($data))
				{
					$token = create_token($data[0]['usrid']);
					$result['token'] = $token;
				}
				else
					$result['error'][] = $error['usr_not_exist'];
			}
			else	
				$result['error'][] = $error['eml_pwrd_missing'];
		}	
	*/
	
	/*
			1.check if email exist
			2.1 if exist 
				2.1.1 if banned 
					2.1.1.1 retunr error
				2.1.2 else	
					2.1.2.1 send recover password email			
			2.2 else 
				2.4.1 return error		
		*/
	/*	public function reset_password()
		{
			if(isset($_POST['usreml']))
			{
				$usreml = $_POST['usreml'];
				$db = new db_session();	
				$query = "select * from usr inner join usrstatus on usrstatusid = usrusrstatusid where usreml = ?";
				$params = array($usreml);	
				$data = db_command::ExecuteQuery($db, $query, $params);
				if(!empty($data))
				{
					if($data[0]['usrstatusauthorized'])
					{
						$new_password = $this->generate_password(5);
						$query = "update usr set usrpwrd = ? where usreml = ?";
						$params = array($new_password,$usreml);	
						db_command::ExecuteNonQuery($db, $query, $params);
						$subject = "she_connect password recovery";
						$msg = "Your new password for she_codes is: ".$new_password;
						$mail_sent = mail($usreml,$subject,$msg);
						if(!$mail_sent)
							$result['error'][] = $error['eml_not_sent'];
					}
					else	
						$result['error'][] = $data[0]['usrstatusname'].'. '.$data[0]['usrstatusremark'];
				}
				else
					$result['error'][] = $error['usr_not_exist'];
			}
			else
				$result['error'][] = $error['eml_missing'];	
		}
		
		/*
			http://stackoverflow.com/questions/1837432/how-to-generate-random-password-with-php
		*/
/*		private function generate_password($length = 8) 
		{
			$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
			$count = mb_strlen($chars);
			
			for ($i = 0, $result = ''; $i < $length; $i++) {
				$index = rand(0, $count - 1);
				$result .= mb_substr($chars, $index, 1);
			}
			return $result;
		}
			*/
}
?>