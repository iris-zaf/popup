<?php
require_once __DIR__ . '/../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'Popup Modal' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!--  FOR LIVE-->
    <link rel="stylesheet" href="/assets/css/frontend-styles.css">
    <!-- FOR localhost
    <link rel="stylesheet" href="<?= PLUGIN_ASSETS ?>css/frontend-styles.css">-->
</head>

<body>