<?php
$base = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];

define('PLUGIN_ROOT', $base . '/');
define('PLUGIN_ASSETS', PLUGIN_ROOT . 'assets/');
define('PLUGIN_UPLOADS', 'uploads/images/popup/');
