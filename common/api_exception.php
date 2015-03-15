<?php
class api_exception extends Exception
{
	private $logid = 0;
	
    public function __construct($message=" ",$code = 0,  Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function get_api_message() {
		global $error_code;
		$msg ="";
		if($this->code != -1) $msg = $this->message;
		$err = array();
		$err['code'] = $this->code;
		$err['message'] = $error_code[$this->code];
		$err['info'] = $msg;
		$err['logid'] = $this->logid;
        return $err;
    }
	
	public function set_logid($logid)
	{
		$this->logid = $logid;
	}
}

function add_log($sevirity,$msg,$code=0)
{
	global $config;	
	if(in_array($sevirity,$config['sevirity']))
	{
		global $token_dal;
		$class = '';
		if(isset($_GET['class'])) $class = $_GET['class'];
		
		$action = '';
		if(isset($_GET['action'])) $action = $_GET['action'];
		$usrid = 0;
		if(isset($_POST['token'])) 
			$usrid = $token_dal->get_usrid_by_token($_POST['token']);
		$log_dal = new log_dal();		
		return $log_dal->insert_log($sevirity,$msg,$code,$class,$action,$usrid,json_encode($_POST));
	}
	return 0;
}
if($config['debug'] == 'false')
	ini_set('display_errors', false);
?>