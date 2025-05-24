<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

$settings = get_popup_settings();
$page = $_GET['page'] ?? 'index';

$allowedPages = ['index', 'home', 'about'];
if (!in_array($page, $allowedPages)) {
    http_response_code(404);
    echo "Page not found";
    exit;
}

$currentPage = $page === 'index' ? 'homepage' : $page;

global $settings, $currentPage;

include __DIR__ . "/{$page}.php";
