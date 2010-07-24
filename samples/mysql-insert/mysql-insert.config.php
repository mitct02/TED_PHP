<?
/* Your MySQL database connection information */
$TED_DB_HOST = 'localhost';	# Hostname or IP address of your MySQL database
$TED_DB_NAME = 'ted';		# Database name of your MySQL database
$TED_DB_USER = 'ted';		# Username to access your MySQL database
$TED_DB_PASS = 'ted5000';	# Password to access your MySQL database


/* Database table names */
$TED_TABLE_MINUTEHISTORY = 'minute_history';	# Table where minute history is to be stored
$TED_TABLE_SECONDHISTORY = 'second_history';	# Table where second history is to be stored


/* Fudge factor for histories */
$TED_HISTORY_FUDGEFACTOR = 1.5;


/* Require TED_PHP */
require '../../TED_PHP.config.php';
require '../../TED_PHP.class.php';
?>