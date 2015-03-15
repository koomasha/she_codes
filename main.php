<?php
try
{
	if(!isset($_GET['class']) || !isset($_GET['action']))
		throw new api_exception('',-102);
	$class = $_GET['class'];
	$action = $_GET['action'];

	if(!(isset($_POST['usrtoken']) || $class == 'login'))
		throw new api_exception('',-101);
	
	$token = null;
	if(isset($_POST['usrtoken']))
		$token = $_POST['usrtoken'];
	if($token != null)
		$usrid = $token_dal->verify_token($token);
	else if($class != 'login')	
		throw new api_exception('',-101);

	if(!file_exists("classes/".$class.".php"))
		throw new api_exception('',-102);

	include_once"classes/".$class.".php";
	if(!method_exists($class,$action))
		throw new api_exception('',-102);
	$class_obj = new $class();
	
	$result['data'] = $class_obj->$action();
	
	$success = new api_exception('',0);
	$result['error'][] = $success->get_api_message(); 
}

//catching api_exception
catch (api_exception $e) 
{     
	$e->set_logid(add_log(1,json_encode($e->get_api_message())."; ".$e,$e->getCode()));
	$error = $e->get_api_message();
	$result['error'][] = $error;
	debug_mode($e,json_encode($_POST));
	
} 

//default exception
catch (Exception $e) 
{  	
	$err = ''.$e;
	$internal_error = new api_exception($err,-1);
	$internal_error->set_logid(add_log(1," ".$e,$e->getCode()));
	$result['error'][] = $internal_error->get_api_message(); 
	debug_mode($e,json_encode($_POST));
}
echo json_encode($result);

?>
