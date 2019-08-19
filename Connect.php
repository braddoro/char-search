<?php
require_once '../adodb5/adodb.inc.php';
class Connect {
	protected $dbo;
	public function conn() {
		$hostname = gethostname();
		$ini_array = parse_ini_file('server.ini', true);
		$hostname = $ini_array['database']['hostname'];
		$username = $ini_array['database']['username'];
		$password = $ini_array['database']['password'];
		$database = $ini_array['database']['dbname'];
		$dbo = ADOnewConnection('mysqli');
		$dbo->setFetchMode(ADODB_FETCH_ASSOC);
		$dbo->connect($hostname, $username, $password, $database);
		$dbo->setCharset('utf8');
		$this->dbo = $dbo;
		return $dbo;
	}
}
