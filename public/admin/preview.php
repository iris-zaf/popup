<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/functions.php';

$page = $_POST['target_page'] ?? $_GET['page'] ?? null;
$settings = get_popup_settings($page);
$mode = $settings['display_mode'] ?? 'standard';
$imageUrl = !empty($settings['image_url']) ? PLUGIN_UPLOADS . htmlspecialchars($settings['image_url']) : '';
$buttonText = htmlspecialchars($settings['button_text'] ?? '');
$buttonLink = htmlspecialchars($settings['button_link'] ?? '#');
$bgColor = htmlspecialchars($settings['button_bg_color'] ?? '#007bff');
$textColor = htmlspecialchars($settings['button_text_color'] ?? '#ffffff');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Popup Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= PLUGIN_ASSETS ?>css/frontend-styles.css">
    <style>
        body {
            background: #f3f3f3;
        }

        #popup {
            display: block;
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
    </style>
</head>

<body>

    <div id="popup" class="popup-<?= $mode ?>" style="<?= ($mode !== 'standard' && $imageUrl) ? "background-image: url('$imageUrl'); background-size: cover; background-position: center;" : '' ?>">

        <?php if (empty($settings['image_url'])): ?>
            <div class="p-4 text-center">
                <div class="alert alert-warning">
                    ⚠️ No popup image found. Please save an image in the admin panel before previewing.
                </div>
            </div>
        <?php else: ?>

            <?php if ($mode === 'standard'): ?>
                <img src="<?= $imageUrl ?>" alt="Popup Image">
                <?php if (!empty($settings['heading'])): ?>
                    <h3><?= htmlspecialchars($settings['heading']) ?></h3>
                <?php endif; ?>
                <?php if (!empty($settings['message'])): ?>
                    <p><?= nl2br(htmlspecialchars($settings['message'])) ?></p>
                <?php endif; ?>
                <?php if (!empty($buttonText)): ?>
                    <a href="<?= !empty($buttonLink) ? $buttonLink : '#' ?>"
                        class="btn"
                        style="background-color: <?= $bgColor ?> !important; color: <?= $textColor ?> !important; <?= empty($buttonLink) ? 'pointer-events: none;' : '' ?>">
                        <?= $buttonText ?>
                    </a>
                <?php endif; ?>

            <?php elseif ($mode === 'background'): ?>
                <a href="<?= $buttonLink ?>" class="popup-full-link" target="_blank" aria-label="Open Link"></a>

            <?php elseif ($mode === 'minimal'): ?>
                <div class="popup-content">
                    <?php if (!empty($buttonText)): ?>
                        <a href="<?= !empty($buttonLink) ? $buttonLink : '#' ?>"
                            class="btn"
                            style="background-color: <?= $bgColor ?> !important; color: <?= $textColor ?> !important; <?= empty($buttonLink) ? 'pointer-events: none;' : '' ?>">
                            <?= $buttonText ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>

</body>

</html>