<?php # config.php
# ---------------------------------------------------------------------
namespace Api;

set_time_limit ( 30000 );

class config
{
	private $dbname;
	private $dbusername;
	private $dbpass;
	
	# define( '_dbconfig_', array( 'dbname', 'host', 'user', 'userpass' ) );
	private function setDefine($post="")
	{
		 
	     
	    $hostw="xxxxxx"; $usrw="xxxxx"; $pswwd="xxxxxx"; $basew="xxxxxx";
		$arraydefine = array( $basew, $hostw, $usrw, $pswwd );  
		return $arraydefine ;
		
	}
	
	
	public function setdbConfig($post="")
	{
			if(@$post)$arraydbconf  =  $this->setDefine($post);
			else $arraydbconf  =  $this->setDefine();
			$this->dbname = $arraydbconf[0];
			$this->dbhost = $arraydbconf[1];
			$this->dbusername = $arraydbconf[2];
			$this->dbpass = $arraydbconf[3];
	}
	public function getDbname () {
		return $this->dbname;
	}
	public function getDbhost () {
		return $this->dbhost;
	}
	public function getDbuser () {
		return $this->dbusername;
	}
	public function getDbpass () {
		return $this->dbpass;
	}
	public function handleException( $exception )  {
      echo "Sorry, a problem occurred. Please try later.";
      error_log( $exception->getMessage() );
	}
	public function getConfig () {
		return array("mysql:host=".$this->getDbhost().";dbname=".$this->getDbname()."", $this->getDbuser(), $this->getDbpass());
	}
}
