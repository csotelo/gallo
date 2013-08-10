<?php
/**
 * @filename security.inc.php
 * @author Carlos Eduardo Sotelo Pinto
 * @date 2009-01-08
 */

session_start();
if (!session_is_registered('logged')) {
    session_register('logged');
    $_SESSION['logged'] = '0';
}
if (!session_is_registered('is_ajax')) {
    session_register('is_ajax');
}
if (!session_is_registered('pnumber')) {
    session_register('pnumber');
}
if (!session_is_registered('ptotal')) {
    session_register('ptotal');
}
if (!session_is_registered('pinit')) {
    session_register('pinit');
}
//$_SESSION['logged'] = '1';
$_SESSION['is_ajax'] = FALSE;
$_SESSION['pnumber'] = 1;
$_SESSION['ptotal'] = 1;
$_SESSION['pinit'] = 1;
?>