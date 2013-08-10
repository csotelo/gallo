<?php
class GfwView {
	protected $_uses = array ();
	protected $_helpers = array ();
	protected $_js_files = array ();
	protected $_css_files = array ();
	protected $_smarty = FALSE;
	
	public function __construct() {
		foreach ($this->uses as $use) {
			$this->$use  = new $use ();
		}
		foreach ($this->_helpers as $helper) {
			$this->$helper  = new $helper ();
		}
		global $smarty;
		$this->_smarty = $smarty;
		$css_html = "";
		foreach ($this->_css_files as $css_file) {
			$css_html .= $this->GfwUrl->get_css_path($css_file) . "\n";
		}
		$this->set('css_zone', $css_html);
		$js_html = "";
		foreach ($this->_js_files as $js_file) {
			$js_html .= $this->GfwUrl->get_js_path($js_file) . "\n";
		}
		$this->set('js_zone', $js_html);
	}

	protected function set ($variable, $value) {
		$this->_smarty->assign ($variable, $value);
	}

	protected function redirect ($view = 'page', $tmpl='index', $id = FALSE, $permanent = FALSE) {
		$url = "/main/%s/%s";
		if ($id) {
			$url .= "/$id";
		}
		$url = sprintf ($url, $view, $tmpl);
		if($permanent)
		{
			header('HTTP/1.1 301 Moved Permanently');
		}
		header('Location: '.$url);
		exit();

	}

	protected function security () {
		if (!$_SESSION['logged']) {
			$this->redirect();
		}
	}


}
?>