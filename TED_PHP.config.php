<?
/* Your TED configuration */
$TED_HOSTNAME = 'ted5000';		# The hostname of your TED gateway device
$TED_PORT = 80;					# The port number of your TED gateway device
$TED_USERNAME = '';				# The authentication username
$TED_PASSWORD = '';				# The authentication password
$TED_SSL = FALSE;				# Enable/Disable SSL +
$TED_API = 'secondhistory';		# The API request to use ++
$TED_MTU = 0;					# The MTU number to retrieve data +++
$TED_TYPE = 'power';			# The field you wish to calculate ++++
$TED_FORMAT = 'raw';			# The format response for the API reqeust +++++


/*
 * Options for settings above:
 *  +     Set to TRUE to enable, FALSE to disable
 *  ++    Options are: livedata, secondhistory, minutehistory, hourlyhistory, monthlyhistory
 *  +++   MTUs are 0-3 (1-4 on a 0-based index) or 'all' for all MTUs
 *  ++++  Options are: power, cost, voltage, and all
 *  +++++ Options are: raw, xml, csv.  Raw is the fastest.  The livedata API only returns XML.
 */
?>