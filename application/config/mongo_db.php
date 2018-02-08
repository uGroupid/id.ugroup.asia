<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['mongo_db']['active'] = 'ugroup';

$config['mongo_db']['ugroup']['no_auth'] = TRUE;
$config['mongo_db']['ugroup']['hostname'] = 'localhost';
$config['mongo_db']['ugroup']['port'] = '27017';
$config['mongo_db']['ugroup']['username'] = 'ureg';
$config['mongo_db']['ugroup']['password'] = '112233fF';
$config['mongo_db']['ugroup']['database'] = 'client_ugroup';
$config['mongo_db']['ugroup']['db_debug'] = TRUE;
$config['mongo_db']['ugroup']['return_as'] = 'array';
$config['mongo_db']['ugroup']['write_concerns'] = (int)1;
$config['mongo_db']['ugroup']['journal'] = TRUE;
$config['mongo_db']['ugroup']['read_preference'] = NULL;
$config['mongo_db']['ugroup']['read_preference_tags'] = NULL;

// $config['mongo_db']['test']['no_auth'] = FALSE;
// $config['mongo_db']['test']['hostname'] = 'localhost';
// $config['mongo_db']['test']['port'] = '27017';
// $config['mongo_db']['test']['username'] = 'username';
// $config['mongo_db']['test']['password'] = 'password';
// $config['mongo_db']['test']['database'] = 'database';
// $config['mongo_db']['test']['db_debug'] = TRUE;
// $config['mongo_db']['test']['return_as'] = 'array';
// $config['mongo_db']['test']['write_concerns'] = (int)1;
// $config['mongo_db']['test']['journal'] = TRUE;
// $config['mongo_db']['test']['read_preference'] = NULL;
// $config['mongo_db']['test']['read_preference_tags'] = NULL;

/* End of file database.php */
/* Location: ./application/config/database.php */
