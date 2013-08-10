<?php
/**
 * Gallo is an PHP Tiny Framework
 *
 * Gallo Copyright (C) 2010,  Carlos Eduardo Sotelo Pinto
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * $Id: gallo.php 16 2009-09-13 05:42:28Z krlosaqp $
 */
$config['gfwroot'] = $config['docroot'] . "core/";
$config['approot'] = $config['docroot'];
$config['sitroot'] = $config['docroot'] . "sites/";


include ($config['gfwroot'] . 'functions/functions.php');
$session = new GfwSession ();
$smarty = new GfwSmarty ();
$view = (isset($_GET['view'])) ? $_GET['view'] : 'page';
$tmpl = (isset($_GET['tmpl'])) ? $_GET['tmpl'] : 'index';
$id   = (isset($_GET['id']))   ? $_GET['id']   : FALSE;
view_loader ($view, $tmpl, $id);
if ($session->CheckNameValue('is_ajax', '1')) {
	exit();
}
$template = $view . '_' . $tmpl;
$logged = ($session->CheckNameValue('logged', '1')) ? '1': '0';
$smarty->assign('logged', $logged);
$smarty->assign('urlpath', $config['urlpath']);
$smarty->assign('tpl_name', $template);
$smarty->display('layout.html');