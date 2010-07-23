<?
/* Get the timestamp of when we start */
$start_ts = time();

/* Require required stuff */
require 'mysql-insert.config.php';
require '../../TED_PHP.config.php';
require '../../TED_PHP.class.php';


/* Set the century */
$century = substr(date('Y'),0,2);


/* Connect to the database */
$db = mysql_connect(TED_DB_HOST, TED_DB_USER, TED_DB_PASS)
	or die('Unable to connect to MySQL server'.PHP_EOL);
mysql_select_db(TED_DB_NAME, $db)
	or die('Unable to open MySQL database'.PHP_EOL);


/* Get the number of seconds since the last update, fall back on Unix epoch if
 * null, and determine our max offset between TED time and database server time */
$query = <<<EOQ
SELECT
	UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(COALESCE(MAX(`insert_ts`),FROM_UNIXTIME(0))) AS `last_update`,
	COALESCE(MAX(UNIX_TIMESTAMP(`timestamp`)-UNIX_TIMESTAMP(`insert_ts`)),0) AS `max_offset`
FROM
	`second_history`
EOQ;
$result = mysql_query($query, $db);
$last_update = mysql_result($result, 0, 'last_update');
$max_offset = mysql_result($result, 0, 'max_offset');


/* Add the offset plus a gratuitous fudge factor */
echo 'Last update was '.number_format($last_update).' second(s) ago.'.PHP_EOL;
echo 'Maximum offset is '.number_format($max_offset).' second(s) ago.'.PHP_EOL;
$last_update += $max_offset*1.5;
echo 'Number of records to retrieve after gratuitous fudge factor is '.number_format($last_update).' record(s).'.PHP_EOL;


/* Don't try to poll more than 1 hour's worth of seconds (3600) */
if($last_update>3600)
	$last_update = 3600;


/* Instantiate the TED_PHP object */
echo 'Fetching '.number_format($last_update).' records . . .'.PHP_EOL;

$ted = new TED_PHP(TED_HOSTNAME, TED_PORT, TED_USERNAME, TED_PASSWORD, TED_SSL, TED_API, TED_MTU, TED_TYPE, TED_FORMAT);
$seconds = $ted->fetch(0,$last_update+2); /* The +2 makes sure we get 3600 ... don't ask me why */


/* Assign TED_MTU to a real variable to be used in the heredoc queries */
$TED_MTU = $ted->get_mtu();


/* Something to count with (offset for our little +2 a few lines above) */
$a = -1;


/* Loop through the results and insert into the table */
foreach($seconds as $second) {
	$timestamp = $century.$second['year'].'-'.$second['month'].'-'.$second['day'].' '.$second['hour'].':'.$second['minute'].':'.$second['second'];
	$query = <<<EOQ
INSERT IGNORE INTO `second_history` (
	`mtu`,
	`timestamp`,
	`power`,
	`cost`,
	`voltage`
) VALUES (
	{$TED_MTU},
	'{$timestamp}',
	{$second['power']},
	{$second['cost']},
	{$second['voltage']}
)
EOQ;

	/* Insert the record */
	mysql_query($query, $db);

	/* Increment our counter */
	$a++;

	/* Display progress for every 100 records */
	if($a%100==0)
		echo 'Inserted '.number_format($a).' records . . .'.PHP_EOL;
}


/* Output the number of queries and how long */
echo 'Inserted '.number_format($a).' records in '.(time()-$start_ts).' second(s).'.PHP_EOL;
?>