<?php
/**
 * @filename config.inc.php
 * @author Carlos Eduardo Sotelo Pinto
 * @date 2009-01-08
 */
 
$config = array ();
 
$config['hostname'] = 'localhost';
$config['username'] = 'rac_maps';
$config['userpass'] = 'rac_maps';
$config['database'] = 'rac_maps';
$config['driver']   = 'mysql';
$config['compile']  = TRUE;
$config['caching']  = FALSE;
$config['docroot']  = '/home/csotelo/public_html/rac_maps/';
$config['urlpath']  = 'http://rac_maps/';
$config['gapikey']  = 'ABQIAAAAXhI2qESVGVvLPFdla9jmThTXJRztQDMtzPP85WjhRMGiWJBbhhQfK6nv76NNA-ZmpgydHUfVnqiYBA';
$config['pagelimit']= 10;
 
include ($config['docroot'] . 'includes/security.inc.php');
include ($config['docroot'] . 'libs/smarty/Smarty.class.php');
include ($config['docroot'] . 'includes/mysmarty.class.php');
include ($config['docroot'] . 'config/settings.php');

 
?>