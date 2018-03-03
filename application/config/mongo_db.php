<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$primary = '192.168.1.221';
$secondary = '192.168.1.223';
$username = "ureg";
$password = "112233fF";
$database = "client_ugroup";
$port = "port";
$dns = 'mongodb://'.$primary.':'.$port.'/'.$database;
try{
	$connect =  new MongoClient("mongodb://".$primary.":27017/".$database, array("username" => $username, "password" => $password));
	$config['mongo_db']['primary']['hostname'] = $primary;
}catch(MongoConnectionException $e){ $config['mongo_db']['primary']['hostname'] = $secondary; }
$config['mongo_db']['active'] = 'primary';
$config['mongo_db']['primary']['no_auth'] = TRUE;
$config['mongo_db']['primary']['port'] = '27017';
$config['mongo_db']['primary']['username'] = 'ureg';
$config['mongo_db']['primary']['password'] = '112233fF';
$config['mongo_db']['primary']['database'] =	'client_ugroup';
$config['mongo_db']['primary']['db_debug'] = TRUE;
$config['mongo_db']['primary']['return_as'] = 'array';
$config['mongo_db']['primary']['write_concerns'] = (int)1;
$config['mongo_db']['primary']['journal'] = TRUE;
$config['mongo_db']['primary']['read_preference'] = NULL;
$config['mongo_db']['primary']['read_preference_tags'] = NULL;

/* End of file database.php */
/* Location: ./application/config/database.php */
