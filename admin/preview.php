<?php
// Return empty if no preview POST data
if (empty($_POST)) {
    echo '<div style="padding:20px; text-align:center;">No preview data received.</div>';
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>

    <link rel="stylesheet" href="../assets/css/admin-styles.css">
</head>

<body>

    <?php if (!empty($_POST['image_url'])): ?>
        <img src="/popup/uploads/images/popup<?= htmlspecialchars($_POST['image_url']) ?>" alt="Preview Image">
    <?php endif; ?>

    <?php if (!empty($_POST['heading'])): ?>
        <h3><?= htmlspecialchars($_POST['heading']) ?></h3>
    <?php endif; ?>

    <?php if (!empty($_POST['message'])): ?>
        <p><?= nl2br(htmlspecialchars($_POST['message'])) ?></p>
    <?php endif; ?>

    <?php if (!empty($_POST['button_text']) && !empty($_POST['button_link'])): ?>
        <a href="<?= htmlspecialchars($_POST['button_link']) ?>" class="btn"
            style="background-color: <?= htmlspecialchars($_POST['button_bg_color'] ?? '#007bff') ?>; color: <?= htmlspecialchars($_POST['button_text_color'] ?? '#ffffff') ?>;"
            target="_blank"><?= htmlspecialchars($_POST['button_text']) ?></a>
    <?php endif; ?>

</body>


</html>