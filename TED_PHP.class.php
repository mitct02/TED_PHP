<?
class TED_PHP {
	public $host, $port, $ssl, $username, $password, $curl, $url, $mtu, $type, $api;

	function __construct($host, $port=80, $username='', $password='', $ssl=FALSE, $api='minutehistory', $mtu=0, $type='power') {
		$this->set_host($host);
		$this->set_port($port);
		$this->set_username($username);
		$this->set_password($password);
		$this->set_ssl($ssl);
		$this->set_api($api);
		$this->set_type($type);
		$this->set_mtu($mtu);

		$this->init_url();
		$this->init_curl();
	}


	function __destruct() {
		if($this->curl)
			curl_close($this->curl);
	}


	public function set_host($host='') {
		$host = trim($host);
		if(strlen($host)>0)
			$this->host = $host;
	}


	public function set_port($port=0) {
		$port = intval($port);
		if($port>0 || $port<65535)
			$this->port = $port;
	}


	public function set_ssl($ssl=FALSE) {
		if($ssl===TRUE || $ssl===FALSE)
			$this->ssl = $ssl;
	}


	public function set_username($username='') {
		$this->username = trim($username);
	}


	public function set_password($password='') {
		$this->password = trim($password);
	}


	public function set_mtu($mtu=0) {
		$mtu = intval($mtu);
		if($mtu>=0)
			$this->mtu = $mtu;
	}


	public function set_type($type='') {
		$type = strtolower(trim($type));
		if(strlen($type)>0 && ($type=='power' || $type=='cost' || $type=='voltage'))
			$this->type = $type;
	}


	public function set_api($api='') {
		$api = strtolower(trim($api));
		if(strlen($api)>0 && ($api=='livedata' || $api=='secondhistory' || $api=='minutehistory' || $api=='hourlyhistory' || $api=='dailyhistory' || $api=='monthlyhistory'))
			$this->api = $api;
	}


	private function init_url() {
		$retval = '';

		if($ssl===TRUE)
			$retval .= 'https://';
		else
			$retval .= 'http://';

		$retval .= $this->host.':'.$this->port.'/';

		
		if($api=='LIVEDATA')
			$retval .= 'api/LiveData.xml';
		else {
			$retval .= 'history/'.strtolower($this->api).'.xml';
			if($this->mtu>0)
				$retval .= '?MTU='.$this->mtu;
		}

		$this->url = $retval;
	}


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


	public function fetch() {
		return curl_exec($this->curl);
	}
}
?>
