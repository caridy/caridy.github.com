<?php
header('Content-Type: application/json; charset=UTF-8;');
include_once($_SERVER['DOCUMENT_ROOT']."/common/3rdparty/PEAR/PEAR.php");
include_once($_SERVER['DOCUMENT_ROOT']."/common/3rdparty/PEAR/JSON.php");

$jscript_path = '/themes/bubbling/jscripts/yui-cms/build/';
if (array_key_exists('module', $_GET) && array_key_exists('lang', $_GET)) {
  $mod = basename ($_GET['module']);
  $lang = basename ($_GET['lang']);
  $charset = $_GET['charset'];
  $file = $_SERVER['DOCUMENT_ROOT'].$jscript_path.$mod.'/lang/'.$lang.'.json';
  if (file_exists ($file)) {
  	require($file);
	// json result
	$json = new Services_JSON ();
	$values = $json->encode($GLOBALS['result']);
	// re-encoding the result...
	$result = false;
	// not neccesary if you use PEAR:JSON
	/*
    if (function_exists('iconv'))
      $result = iconv("ISO-8859-1", "UTF-8", $values);
    elseif (function_exists('mb_convert_encoding'))
      $result = mb_convert_encoding($values, "UTF-8", "ISO-8859-1");
    */
    echo ($result != false?$result:$values);
  }
}
?>