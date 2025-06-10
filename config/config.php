<?php
require __DIR__ . '/../vendor/autoload.php';
//for localhost
$base = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
//for live:
//$base = 'https://' . $_SERVER['HTTP_HOST'];
define('PLUGIN_ROOT', $base . '/');
define('PLUGIN_ASSETS', PLUGIN_ROOT . 'assets/');
define('PLUGIN_UPLOADS', PLUGIN_ROOT . 'uploads/images/popup/');


$mongoUri = 'mongodb+srv://irisk:kY0Eak8EAHLj0Esm@popup.mmt3buw.mongodb.net/?retryWrites=true&w=majority&appName=popup';

//mongodb connection --Render --
//$mongoUri = getenv('MONGO_URI');

try {
    $mongoClient = new MongoDB\Client($mongoUri);

    $mongoDb = $mongoClient->selectDatabase('popup_db');
} catch (MongoDB\Driver\Exception\Exception $e) {
    die("MongoDB Connection failed: " . $e->getMessage());
}
