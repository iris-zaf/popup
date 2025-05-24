<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/functions.php';

$settings = get_popup_settings();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Popup Test Page</title>
    <link rel="stylesheet" href="<?= PLUGIN_ASSETS ?>css/frontend-styles.css">
</head>

<body>
    <div class="container my-auto text-center py-5">
        <div class="card shadow-lg p-4 mx-auto" style="max-width: 600px;">
            <h1 class="card-title mb-3">🎉 Welcome to the Popup Test Page</h1>
            <p class="card-text">This is a demo page to showcase how your popup plugin works.</p>
            <p class="text-muted">You can trigger the popup by <strong>exit intent</strong> or after a
                <strong>time delay</strong>, depending on your settings.
            </p>
        </div>
    </div>

    <?php include __DIR__ . '/views/popup-view.php'; ?>

    <script>
    const settings = <?= json_encode($settings) ?>;
    </script>
    <script src="<?= PLUGIN_ASSETS ?>js/frontend-scripts.js"></script>
</body>

</html>