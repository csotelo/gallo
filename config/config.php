<?php
/**
 * @filename config.inc.php
 * @author Carlos Eduardo Sotelo Pinto
 * @date 2009-01-08
 */

$config['hostname'] = 'localhost';
$config['username'] = 'username';
$config['userpass'] = 'userpass';
$config['database'] = 'database';
$config['driver']   = 'mysql';
$config['compile']  = TRUE;
$config['caching']  = FALSE;
$config['pagelimit']= 10;
$config['gapikey']  = '';
$config['saltkey']  = 'ABQIAAAAXhI2qESVGVvLPFdla9jmThTX';
$config['sites']    = array ('main');

include ($config['docroot'] . 'core/main.php');

?>