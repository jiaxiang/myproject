<?php
//$CLI = 1;
//var_dump($_GET['lujiaxiang']);
//var_dump($_SERVER);
require_once 'init.php';
$get_var = getRequest('lujiaxiang');
$get_var = str_replace(WEBPATH, '/', $get_var);
//echo $get_var;
//die();
$get_var = substr($get_var, 1);
$get_var_arr = explode('/', $get_var);
if (!isset($get_var_arr[0]) || $get_var_arr[0] == null) {
	//$c_name = 'indexController';
	$c_name = 'projectsetController';
}
else {
	$c_name = trim($get_var_arr[0]).'Controller';
}

array_shift($get_var_arr);

if (!isset($get_var_arr[0]) || $get_var_arr[0] == null) {
	$f_name = 'index';
}
else {
	$f_name = trim($get_var_arr[0]);
}
//var_dump($f_name);
array_shift($get_var_arr);
$p_arr = $get_var_arr;
if (!is_file(BASEPATH.'controller/'.$c_name.'.php')) {
	die('error url');
}
$c_path = BASEPATH.'controller/'.$c_name.'.php';
require_once $c_path;
$controller = new $c_name;
$controller->$f_name();
//call_user_func_array
?>