<?php
/**
 * @filename index.php
 * @author Carlos Eduardo Sotelo Pinto
 * @date 2009-01-08
 */
include ($config['gfwroot'] . 'libs/smarty/Smarty.class.php');
class GfwSmarty extends Smarty {
	function GfwSmarty () {
		global $config;
		$this->Smarty();

		$this->template_dir  = $config['approot'] . 'sites/main/templates/';
		$this->compile_dir   = $config['approot'] . 'compiles/';
		$this->config_dir    = $config['approot'] . 'configs/';
		$this->cache_dir     = $config['approot'] . 'cache/';
		$this->compile_check = $config['compile'];
		$this->force_compile = $config['compile'];
		$this->caching       = $config['caching'];
		$this->assign('app_name', 'Maps');
	}
}
?>
