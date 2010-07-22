<?
class TED_PHP {
	private $host, $port, $ssl, $username, $password, $curl, $url, $mtu, $type, $api;

	function __construct($host, $port=80, $username='', $password='', $ssl=FALSE, $api='minutehistory', $mtu=0, $type='power', $format='raw') {
		$this->set_host($host);
		$this->set_port($port);
		$this->set_username($username);
		$this->set_password($password);
		$this->set_ssl($ssl);
		$this->set_api($api);
		$this->set_type($type);
		$this->set_mtu($mtu);
		$this->set_format($format);

		$this->init_url();
		$this->init_curl();
	}


	function __destruct() {
		/* Close the cURL session if it's open */
		if($this->curl) {
			curl_close($this->curl);
			unset($this->curl);
		}
	}


	/* Set the gateway hostname */
	public function set_host($host='') {
		$host = trim($host);
		if(strlen($host)>0)
			$this->host = $host;
	}


	/* Set the gateway port */
	public function set_port($port=0) {
		$port = intval($port);
		if($port>0 || $port<65535)
			$this->port = $port;
	}


	/* Enable/Disable SSL */
	public function set_ssl($ssl=FALSE) {
		if($ssl===TRUE || $ssl===FALSE)
			$this->ssl = $ssl;
	}


	/* Set the gateway authentication username */
	public function set_username($username='') {
		$this->username = trim($username);
	}


	/* Set the gateway authentication password */
	public function set_password($password='') {
		$this->password = trim($password);
	}


	/* Set the MTU number */
	public function set_mtu($mtu=0) {
		$mtu = intval($mtu);
		if($mtu>=0)
			$this->mtu = $mtu;
	}


	/* Set the type of data to be returned (power, cost, voltage, all) */
	public function set_type($type='') {
		$type = strtolower(trim($type));
		if(strlen($type)>0 && ($type=='power' || $type=='cost' || $type=='voltage' || $type=='all'))
			$this->type = $type;
	}


	/* Set which API to query */
	public function set_api($api='minutehistory') {
		$api = strtolower(trim($api));
		if(strlen($api)>0 && ($api=='livedata' || $api=='secondhistory' || $api=='minutehistory' || $api=='hourlyhistory' || $api=='dailyhistory' || $api=='monthlyhistory'))
			$this->api = $api;
	}


	/* Set the return format. Raw is faster, thus recommended */
	public function set_format($format='raw') {
		$format = strtolower(trim($format));
		if(strlen($format)>0 && ($format=='raw' || $format=='xml' || $format=='csv'))
			$this->format = $format;
	}


	/* Build the API request URL from all the specified options */
	private function init_url() {
		$retval = '';

		if($ssl===TRUE)
			$retval .= 'https://';
		else
			$retval .= 'http://';

		$retval .= $this->host.':'.$this->port.'/';

		
		if($api=='livedata')
			$retval .= 'api/LiveData.xml';
		else {
			$retval .= 'history/';

			if($format=='raw')
				$retval .= 'raw';

			$retval .= strtolower($this->api);

			switch($format) {
				case 'raw':
					$retval .= '.raw';
					break;
				case 'csv':
					$retval .= '.csv';
					break;
				default:
					$retval .= '.xml';
			}

			if($this->mtu>0)
				$retval .= '?MTU='.$this->mtu;
		}

		$this->url = $retval;
	}


	/* Initialize cURL */
	private function init_curl() {
		$retval = curl_init();

		curl_setopt_array($retval, array(
			CURLOPT_URL => $this->url,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HEADER => FALSE,
			CURLOPT_CONNECTTIMEOUT => 30,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_FAILONERROR => TRUE,
			CURLOPT_HTTPGET => TRUE,
			CURLOPT_NOPROGRESS => TRUE,
			CURLOPT_PORT => $this->port
		));


		switch($ssl) {
			case TRUE:
				curl_setopt($retval, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
			default:
				curl_setopt($retval, CURLOPT_PROTOCOLS, CURLPROTO_HTTP);
		}


		if(strlen($this->username)>0 && strlen($this->password>0))
			$curl_setopt($retval, CURLOPT_USERPWD, $this->username.':'.$this->password);

		$this->curl = $retval;
	}


	/* Do a basic fetch */
	public function fetch() {
		return curl_exec($this->curl);
	}
}
?>
