<?php
class GfwUrl extends GfwHelper {
	private $_url_path;
	private $_js_path;
	private $_css_path;
	private $_image_path;

	function __construct() {
		$this->__init_attributes();
	}

	function __destruct() {}

	private function __init_attributes () {
		global $config;
		$this->_url_path = $config['urlpath'];
		$this->_media_path = $this->_url_path . "media/";
	}
	public function get_url () {
	}

	public function get_url_path () {}

	public function get_js_path ($js_file, $js_path = "js") {
		return '<script type="text/javascript" src="' .$this->_media_path . $js_path . '/' . $js_file . '" ></script>';
	}

	public function get_css_path ($css_file, $css_path = "css") {
		return '<link rel="stylesheet" type="text/css" href="' .$this->_media_path . $css_path. '/' . $css_file . '" />';
	}
	public function get_image_path ($image_file, $options=array(), $image_path = "image", $html = FALSE) {
		$attributes = "";
		$image_src = $this->_media_path . $image_path. '/' . $image_file;
		if (!$html) {
			foreach ($options as $key => $value) {
				$attributes .= '$key="$value" ';
			}
			return '<img src="' . $image_src . '" ' . $attributes . '/>';
		} else {
			return $image_src;
		}
	}

	public function print_url_path () {
		print $this->get_url_path ();
	}

	public function print_js_path ($js_file) {
		print $this->get_js_path ($js_file);
	}

	public function print_css_path ($css_file) {
		print $this->get_css_path ($css_file);
	}

	public function print_image_path ($image_file, $options = array()) {
		print $this->get_image_path ($image_file, $options);
	}
}