<?php	
	$error_code = array();
	$error_code[0] = 'Success';
	$error_code[-1]="Internal Error";
	
	//Data missing
	$error_code[-101] = "Token missing";
	$error_code[-102] = "Wrong URL";
	$error_code[-104] = "Data missing";

	
	//Invalid Data	
	$error_code[-203] = "Token does not exist";
	$error_code[-204] = "User not found";
	$error_code[-205] = "Token is expired";
	$error_code[-206] = "Unknown token";	
	$error_code[-207] = "Page number must be greater than 0";
	$error_code[-208] = "Invalid Data";
	
	//Errors from user side
	$error_code[-301] = "User logged in to system with Facebook";
	$error_code[-302] = "User exist in the system";
	$error_code[-303] = "Email not sent";
	$error_code[-303] = "User account is not valid";
?>