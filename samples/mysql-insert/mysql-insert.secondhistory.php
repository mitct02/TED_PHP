<?
/* Require required stuff */
require 'mysql-insert.config.php';
require '../../TED_PHP.config.php';
require '../../TED_PHP.class.php';

$db = mysql_connect(TED_DB_HOST, TED_DB_USER, TED_DB_PASS)
	or die('Unable to connect to MySQL server'.PHP_EOL);
mysql_select_db(TED_DB_NAME, $db)
	or die('Unable to open MySQL database'.PHP_EOL);


/* Get the max timestamp for the seconds */
$query = "SELECT COALESCE(MAX(`timestamp`),FROM_UNIXTIME(0)) AS `timestamp` FROM `secondhistory`";
$result = mysql_query($query, $db);
$max_timestamp = mysql_result($result, 0);
?>