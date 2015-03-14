<?php
class db_session {

	private $connection;
	
	public function __construct() { 
		global $config;
    	$dsn = $config['dsn'];
		$user = $config['user'];
		$password = $config['password'];
			
		try 
		{
			$this->connection = new PDO($dsn, $user, $password);
   		}
		catch(PDOException $e)
		{
    		throw new api_exception($e->getMessage(),-1);
		}
	}
	

    public  function get_connection() {
       if (! $this->connection )
		{
			throw new Exception('connection is null');
		}
        return $this->connection;
    }
}
?>