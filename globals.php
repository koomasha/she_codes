<?php
	
	$result = array();
	$result['error'] = array();
	$result['data'] = array();	
	include_once "config.php";
	
	function debug_mode($err,$post)
	{
		global $result;
		global $config;
		if($config['debug'] == 'true')
		{
			$result['InternalError'][] = $err;
			$result['post'][] = $post;
		}
	}
	
	register_shutdown_function(function () 
	{
		$error = error_get_last();
		if( $error !== NULL) 
		{
			error_log( json_encode($error) ."\n",3,"shecodes.log");
			ob_clean();
			
			$err = array();
			$err['code'] = -1;
			$err['message'] = "Internal Error";
			$err['info'] = "";
			$result['error'][] = $err;
			debug_mode($error,json_encode($_POST));
			echo json_encode($result);
		}
	} );
	include_once "common/db_session.php";
	include_once "common/db_command.php";
	include_once "common/errorcodes.php";
	include_once "dal/log_dal.php";
	include_once "common/api_exception.php";
	include_once "dal/token_dal.php";

	register_shutdown_function(function () 
	{
		$error = error_get_last();
		if( $error !== NULL) 
		{
			$internal_error = new api_exception('',-1);
			$internal_error->set_logid(add_log(1,json_encode($error),-1));
			ob_clean();
			$result['error'][] = $internal_error->get_api_message(); 
			debug_mode($error,json_encode($_POST));
			echo json_encode($result);
		}
	});

	include_once "dal/user_dal.php";
	include_once "dal/branch_dal.php";

	$token_dal = new token_dal();
	$user_dal = new user_dal();
	$branch_dal = new branch_dal();
	
?>