<?php
function __autoload($class_name) {
    global $config;
    $gfwpt = array ('classes/', 
    				'drivers/', 
    				'helpers/', 
    				'includes/',
    				);
    $apppt = array ('classes/');
    $classname = callable ($class_name);
    $found = FALSE;
    $class_path = "";
    if (!$found) {
    	foreach ( $gfwpt as $path) {
    		$class_path = $config['gfwroot'] . $path . $classname . '.php';
    		if (file_exists($class_path)) {
    			$found = TRUE;
    			break;
    		}
    	}
    }
	if (!$found) {
		foreach ( $apppt as $path) {
			$class_path = $config['approot'] . $path . $classname . '.php';
			if (file_exists($class_path)) {
    			$found = TRUE;
    			break;
    		}
		}
	}
	if (!$found) {
		foreach ( $config['sites'] as $site) {
			$class_path = $config['sitroot'] . $site ."/views/". $classname . '_view.php';
			if (file_exists($class_path)) {
    			$found = TRUE;
    			break;
    		}
		}
	}
	if (!$found) {
		$class_path = $config['approot'] . "models/". $classname . '_model.php';
		if (file_exists($class_path)) {
    		$found = TRUE;
    	}
	}
	if ($found) {
		require_once $class_path;
	}
	else
	{
		echo '*' . $class_path ;
		exit();
	}
}

function callable ($classname) {
    $uppers  = str_split ('ABCDEFGHIJKLMNOPRSTUVWXYZ');
    //$lowers  = str_split ('abcdefghijklmnoprstuvwxyz');
    $letters = str_split ($classname);
    $tmp     = array();
    foreach ($letters as $key => $letter) {
        if (in_array($letter, $uppers) and $key > 0) {
            $tmp[] = '_';
        }
        $tmp[] = strtolower($letter);
    }
    return implode('', $tmp);
}

function loadable ($classname) {
    $names   = explode('_', $classname);
    $tmp = array();
    foreach ($names as $name) {
        $tmp[] = ucfirst($name);
    }
    return implode('', $tmp);
}

function view_loader ($view, $template = 'index', $id = FALSE) {
	$view = loadable($view);
    $v = new $view();
    if ($id) {
    	$v->$template($id);
    } else {
    	$v->$template();
    }
}