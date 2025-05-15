<?php
require_once __DIR__ . '/../config/config.php';

if (empty($_POST)) {
    echo '<div style="padding:20px; text-align:center;">No preview data received.</div>';
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= PLUGIN_ASSETS ?>css/frontend-styles.css">
</head>

<body>

    <div id="popup" style="display: block; transform: translate(-50%, -50%) scale(1); opacity: 1;">

        <?php if (!empty($_POST['image_url'])): ?>
            <img src="<?= PLUGIN_UPLOADS . htmlspecialchars($_POST['image_url']) ?>" alt="Popup Image">
        <?php endif; ?>

        <?php if (!empty($_POST['heading'])): ?>
            <h3><?= htmlspecialchars($_POST['heading']) ?></h3>
        <?php endif; ?>

        <?php if (!empty($_POST['message'])): ?>
            <p><?= nl2br(htmlspecialchars($_POST['message'])) ?></p>
        <?php endif; ?>

        <?php if (!empty($_POST['button_text']) && !empty($_POST['button_link'])): ?>
            <a href="<?= htmlspecialchars($_POST['button_link']) ?>" class="btn" style="background-color: <?= htmlspecialchars($_POST['button_bg_color'] ?? '#007bff') ?>;
              color: <?= htmlspecialchars($_POST['button_text_color'] ?? '#ffffff') ?>;"
                target="_blank"><?= htmlspecialchars($_POST['button_text']) ?></a>
        <?php endif; ?>
    </div>
</body>


</html>