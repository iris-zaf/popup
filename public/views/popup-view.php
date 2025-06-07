<?php

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/functions.php';
$settings = get_popup_settings();
$mode = $settings['display_mode'] ?? 'standard';
$imageUrl = !empty($settings['image_url']) ? '/uploads/images/popup/' . htmlspecialchars($settings['image_url']) : '';
$buttonText = htmlspecialchars($settings['button_text'] ?? '');
$buttonLink = htmlspecialchars($settings['button_link'] ?? '#');
$bgColor = htmlspecialchars($settings['button_bg_color'] ?? '#007bff');
$textColor = htmlspecialchars($settings['button_text_color'] ?? '#ffffff');
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
    <div id="popup" class="popup-<?= $mode ?>" style="<?= ($mode !== 'standard' && $imageUrl) ? "background-image: url('$imageUrl'); background-size: cover; background-position: center;" : '' ?>">
        <span id="popup-close" onclick="closePopup()">×</span>
        <?php if ($mode === 'standard'): ?>
            <?php if (!empty($settings['image_url'])): ?>
                <img src="/uploads/images/popup/<?= htmlspecialchars($settings['image_url']) ?>" alt="Popup Image">
            <?php endif; ?>

            <?php if (!empty($settings['heading'])): ?>
                <h3><?= htmlspecialchars($settings['heading']) ?></h3>
            <?php endif; ?>

            <?php if (!empty($settings['message'])): ?>
                <p><?= nl2br(htmlspecialchars($settings['message'])) ?></p>
            <?php endif; ?>

            <?php if (!empty($buttonText)): ?>
                <a href="<?= !empty($buttonLink) ? $buttonLink : '#' ?>"
                    class="btn"
                    style="background-color: <?= $bgColor ?> !important; color: <?= $textColor ?> !important; <?= empty($buttonLink) ? 'pointer-events: none; opacity: 0.6;' : '' ?>"
                    <?= !empty($buttonLink) ? 'target="_blank"' : '' ?>>
                    <?= $buttonText ?>
                </a>
            <?php endif; ?>
        <?php elseif ($mode === 'background'): ?>
            <?php if (!empty($buttonLink)): ?>
                <a href="<?= $buttonLink ?>" class="popup-full-link" target="_blank" aria-label="Open Popup Link"></a>
            <?php endif; ?>

        <?php elseif ($mode === 'minimal'): ?>
            <div class="popup-content">
                <?php if (!empty($buttonText)): ?>
                    <a href="<?= !empty($buttonLink) ? $buttonLink : '#' ?>"
                        class="btn"
                        style="background-color: <?= $bgColor ?> !important; color: <?= $textColor ?> !important; <?= empty($buttonLink) ? 'pointer-events: none; opacity: 0.6;' : '' ?>"
                        <?= !empty($buttonLink) ? 'target="_blank"' : '' ?>>
                        <?= $buttonText ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <script>
        const settings = <?= json_encode($settings) ?>;
    </script>
    <script src="<?= PLUGIN_ASSETS ?>js/frontend-scripts.js"></script>
</body>

</html>