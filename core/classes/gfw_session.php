<?php
class GfwSession extends GfwHash {
	private $check_browser;
	private $check_ip_blocks;
	private $secure_word;
	private $regenerate_id;

	function __construct() {
		$this->GfwSession();
	}

	function GfwSession () {
		if(!isset($_SESSION)) {
			session_start();
		}
		$this->__initAttributes();
		$this->GfwHash($this->secure_word);
	}

	private function __initAttributes () {
		global $config;
		$this->check_browser = true;
		$this->check_ip_blocks = 0;
		$this->secure_word = $config['saltkey'];
		$this->regenerate_id = true;
	}

	public function Open () {
		$this->SetName('ss_fprint', $this->_Fingerprint());
		$this->_RegenerateId();
	}

	public function Check () {
		$this->_RegenerateId();
		return $this->CheckNameValue('ss_fprint', $this->_Fingerprint());
	}

	private function _Fingerprint() {
		$fingerprint = $this->secure_word;
		if ($this->check_browser) {
			$fingerprint .= $_SERVER['HTTP_USER_AGENT'];
		}
		if ($this->check_ip_blocks) {
			$num_blocks = abs(intval($this->check_ip_blocks));
			if ($num_blocks > 4) {
				$num_blocks = 4;
			}
			$blocks = explode('.', $_SERVER['REMOTE_ADDR']);
			for ($i = 0; $i < $num_blocks; $i++) {
				$fingerprint .= $blocks[$i] . '.';
			}
		}
		return $fingerprint;
	}

	function _RegenerateId () {
		if ($this->regenerate_id && function_exists('session_regenerate_id')) {
			if (version_compare('5.1.0', phpversion(), '>=')) {
				session_regenerate_id(true);
			} else {
				session_regenerate_id();
			}
		}
	}

	public function GetValue ($name) {
		$name = md5 ($name);
		if (session_is_registered($name)) {
			$value = $this->decrypt ($_SESSION[$name]);
			return $value;
		} else {
			return FALSE;
		}
	}

	public function SetName($name,$value) {
		$name = md5($name);
		$value = $this->encrypt($value);
		if (!session_is_registered($name)) {
			session_register ($name);
		}
		$_SESSION[$name] = $value;
	}

	function DeleteName ($name) {
		$name = md5 ($name);
		if (session_is_registered($name)) {
			session_unregister($name);
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function CheckNameValue ($name, $value) {
		$name = md5 ($name);
		$value = $this->encrypt ($value);
		if (session_is_registered($name)) {
			if ($this->decrypt($name) == $value){
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	function destroy()
	{
		$this->__setting->_session = array();
		session_destroy();
	}

	function fromArray($a=null)
	{
		if(is_array($a))
		{
			foreach($a as $k => $v) $this->$k = $v;
		}
	}

	function toArray()
	{
		return $this->__setting->_session;
	}

}