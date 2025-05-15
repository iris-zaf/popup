<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

$settings = get_popup_settings();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Popup Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= PLUGIN_ASSETS ?>css/frontend-styles.css">
</head>

<body>

    <div id="popup" style="display: block; transform: translate(-50%, -50%) scale(1); opacity: 1;">

        <?php if (empty($settings['image_url'])): ?>
            <div class="p-4 text-center">
                <div class="alert alert-warning">
                    ⚠️ No popup image found. Please save an image in the admin panel before previewing.
                </div>
            </div>
        <?php else: ?>

            <img src="<?= PLUGIN_UPLOADS . htmlspecialchars($settings['image_url']) ?>" alt="Popup Image">

            <?php if (!empty($settings['heading'])): ?>
                <h3><?= htmlspecialchars($settings['heading']) ?></h3>
            <?php endif; ?>

            <?php if (!empty($settings['message'])): ?>
                <p><?= nl2br(htmlspecialchars($settings['message'])) ?></p>
            <?php endif; ?>

            <?php if (!empty($settings['button_text']) && !empty($settings['button_link'])): ?>
                <a href="<?= htmlspecialchars($settings['button_link']) ?>" class="btn" style="background-color: <?= htmlspecialchars($settings['button_bg_color']) ?>;
                      color: <?= htmlspecialchars($settings['button_text_color']) ?>;"
                    target="_blank"><?= htmlspecialchars($settings['button_text']) ?></a>
            <?php endif; ?>

        <?php endif; ?>

    </div>

</body>

</html>