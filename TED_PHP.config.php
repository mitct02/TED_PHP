<?
/* Your TED configuration */
define('TED_HOSTNAME', 'TED5000');		# The hostname of your TED gateway device
define('TED_PORT', 5000);				# The port number of your TED gateway device
define('TED_USERNAME', '');				# The authentication username
define('TED_PASSWORD', '');				# The authentication password
define('TED_SSL', FALSE);				# Enable/Disable SSL +
define('TED_API', 'secondhistory');		# The API request to use ++
define('TED_MTU', 0);					# The MTU number to retrieve data +++
define('TED_TYPE', 'all');				# The field you wish to calculate ++++
define('TED_FORMAT', 'raw');			# The format response for the API reqeust +++++


/*
 * Options for settings above:
 *  +     Set to TRUE to enable, FALSE to disable
 *  ++    Options are: livedata, secondhistory, minutehistory, hourlyhistory, monthlyhistory
 *  +++   MTUs are 0-3 (1-4 on a 0-based index) or 'all' for all MTUs
 *  ++++  Options are: power, cost, voltage, and all
 *  +++++ Options are: raw, xml, csv.  Raw is the fastest.  The livedata API only returns XML.
 */
?>