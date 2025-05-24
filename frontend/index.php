<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

$settings = get_popup_settings();

$page = $_GET['page'] ?? 'home';
$currentPageKey = $page;
$allowedPages = ['home', 'about'];
if (!in_array($page, $allowedPages)) {
    http_response_code(404);
    echo "Page not found";
    exit;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= ucfirst($page) ?> Page</title>
    <link rel="stylesheet" href="<?= PLUGIN_ASSETS ?>css/frontend-styles.css">
</head>

<body>
    <div class="container">

        <?php include __DIR__ . "/$page.php"; ?>
    </div>

    <?php
    if (
        $settings['enabled'] &&
        ($settings['target_page'] === 'all' || $settings['target_page'] === $currentPageKey)
    ): ?>
        <?php include __DIR__ . '/../views/popup-view.php'; ?>

    <?php endif; ?>

    <script>
        const settings = <?= json_encode($settings) ?>;
    </script>
    <script src="<?= PLUGIN_ASSETS ?>js/frontend-scripts.js"></script>
</body>

</html>