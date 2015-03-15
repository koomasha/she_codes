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
	
	include_once "globals.php";
?>