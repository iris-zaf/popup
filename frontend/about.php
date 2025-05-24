<!DOCTYPE html>
<html>

<head>
    <title>Home Page</title>
    <link rel="stylesheet" href="<?= PLUGIN_ASSETS ?>css/frontend-styles.css">
</head>

<body>
    <div class="container">
        <h1> This is the About Page</h1>
        <p>Welcome to the homepage demo!</p>
    </div>

    <?php if (
        $settings['enabled'] &&
        ($settings['target_page'] === 'all' || $settings['target_page'] === 'homepage')
    ): ?>
        <?php include __DIR__ . '/../views/popup-view.php'; ?>
    <?php endif; ?>

    <script>
        const settings = <?= json_encode($settings) ?>;
    </script>
    <script src="<?= PLUGIN_ASSETS ?>js/frontend-scripts.js"></script>
</body>

</html>