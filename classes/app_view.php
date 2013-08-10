<?php
class AppView extends GfwView {
	protected $_helpers = array ('GfwUrl');
	protected $_js_files = array ('mootools.js', 'jquery.js', 'jquery.dimensions.min.js', 'jquery.tooltip.min.js');
	protected $_css_files = array ('style.css', 'jquery.tooltip.css', 'tooltipv2.css');
	
	function __construct() {
		parent::__construct();
	} 
	
}