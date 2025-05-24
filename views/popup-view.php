<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';
$settings = get_popup_settings();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Popup Test Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/popup/assets/css/frontend-styles.css">
</head>

<body>

    <div id="popup-overlay"></div>
    <div id="popup">
        <span id="popup-close" onclick="closePopup()">×</span>

        <?php if (!empty($settings['image_url'])): ?>
            <img src="/uploads/images/popup/<?= htmlspecialchars($settings['image_url']) ?>" alt="Popup Image">
        <?php endif; ?>

        <?php if (!empty($settings['heading'])): ?>
            <h3><?= htmlspecialchars($settings['heading']) ?></h3>
        <?php endif; ?>

        <?php if (!empty($settings['message'])): ?>
            <p><?= nl2br(htmlspecialchars($settings['message'])) ?></p>
        <?php endif; ?>

        <?php if (!empty($settings['button_text']) && !empty($settings['button_link'])): ?>
            <a href="<?= htmlspecialchars($settings['button_link']) ?>" class="btn" style="background-color: <?= htmlspecialchars($settings['button_bg_color'] ?? '#007bff') ?>;
                      color: <?= htmlspecialchars($settings['button_text_color'] ?? '#ffffff') ?>;" target="_blank">
                <?= htmlspecialchars($settings['button_text']) ?>
            </a>
        <?php endif; ?>
    </div>
    <script>
        const settings = <?= json_encode($settings) ?>;
    </script>
    <script src="<?= PLUGIN_ASSETS ?>js/frontend-scripts.js"></script>
</body>

</html>