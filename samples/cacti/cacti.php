<?
/* Require required stuff */
$require_path = realpath(dirname(__FILE__).'/../../');
require $require_path.'/TED_PHP.config.php';
require 'config.php';
require $require_path.'/TED_PHP.class.php';


/* Switch to the minute history and all types */
$TED_API = 'minutehistory';
$TED_TYPE = 'all';


/* Instantiate our object */
$ted = new TED_PHP($TED_HOSTNAME, $TED_PORT, $TED_USERNAME, $TED_PASSWORD, $TED_SSL, $TED_API, $TED_MTU, $TED_TYPE, $TED_FORMAT);


/* Make the call */
$response = $ted->fetch(0,6);


/* Format our response */
$retval = array(
	'timestamp' => 0,
	'power' => 0,
	'cost' => 0,
	'voltage' => 0
);

foreach($response as $r) {
	if(mktime($r['hour'], $r['minute'], $r['second'], $r['month'], $r['day'], $r['year'])>$retval['timestamp'])
		$retval['timestamp'] = mktime($r['hour'], $r['minute'], $r['second'], $r['month'], $r['day'], $r['year']);

	$retval['power'] += $r['power'];
	$retval['cost'] += $r['cost'];
	$retval['voltage'] += $r['voltage'];
}


/* Average our numbers */
$retval['power'] /= count($response);
$retval['cost'] /= count($response);
$retval['voltage'] /= count($response);


/* Return */
$retval['timestamp'] = date('Y-m-d H:i:s', $retval['timestamp']);
unset($retval['timestamp']);
$output = '';
foreach($retval as $r_k => $r_v)
	$output .= $r_k.':'.$r_v.' ';

echo trim($output);
?>