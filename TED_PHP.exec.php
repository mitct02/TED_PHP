<?
/* Require required stuff */
require 'TED_PHP.config.php';
require 'TED_PHP.class.php';


/* Instantiate the object */
$ted = new TED_PHP($TED_HOSTNAME, $TED_PORT, $TED_USERNAME, $TED_PASSWORD, $TED_SSL);


/* Set command-line options */
$short_options = 'a:i::c::h';
$long_options = array(
	'api:',
	'index::',
	'count::',
	'help'
);

$options = getopt($short_options, $long_options);

if(count($options)==0 || isset($options['h']) || isset($options['help'])) {
	help();
} else {
	if(isset($options['a']))
		$api = $options['a'];
	elseif(isset($options['api']))
		$api = $options['api'];
	
	if(isset($options['i']))
		$index = $options['i'];
	elseif(isset($options['index']))
		$index = $options['index'];
	
	if(isset($options['c']))
		$count = $options['c'];
	elseif(isset($options['count']))
		$count = $options['count'];
	
	$api = strtolower(trim($api));
	$index = intval($index);
	$count = intval($count);

	if(strlen($api)==0) {
		help();
		exit;
	}
	
	$ted->set_api($api);
	print_r($ted->fetch($index,$count));
}


function help() {
	echo "TED_PHP Usage:".PHP_EOL;
	echo "\t-a (--api)\tSelect API (LiveData, SecondHistory, MinuteHistory, DailyHistory)".PHP_EOL;
	echo "\t-i (--index)\tSet starting index for history APIs".PHP_EOL;
	echo "\t-c (--count)\tSet count rows returned for history APIs".PHP_EOL;
	echo "\t-h\t\tThis help".PHP_EOL;
	echo PHP_EOL;
	echo "Example: ".$_SERVER['_']." ".$_SERVER['argv'][0]." -a secondhistory -i1 -c2".PHP_EOL;
	echo "Example: ".$_SERVER['_']." ".$_SERVER['argv'][0]." --api=secondhistory --index=1 --count=2".PHP_EOL;
}
?>
