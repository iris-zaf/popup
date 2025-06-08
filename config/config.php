<?php
//for localhost
//$base = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
//for live:
$base = 'https://' . $_SERVER['HTTP_HOST'];
define('PLUGIN_ROOT', $base . '/');
define('PLUGIN_ASSETS', PLUGIN_ROOT . 'assets/');
define('PLUGIN_UPLOADS',  PLUGIN_ROOT . 'uploads/images/popup/');
