<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../includes/functions.php';

$settings = get_popup_settings();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $buttonLink = $_POST['button_link'] ?? '';
    if ($buttonLink && !preg_match('/^https?:\/\//', $buttonLink)) {
        $buttonLink = 'https://' . $buttonLink;
    }
    $newSettings = [
        'enabled' => $_POST['enabled'] == '1' ? true : false,
        'trigger' => $_POST['trigger'],
        'cookie_duration' => isset($_POST['cookie_duration']) ? (int) $_POST['cookie_duration'] : 1,
        'heading' => $_POST['heading'] ?? '',
        'message' => $_POST['message'] ?? '',
        'target_page' => $_POST['target_page'] ?? 'all',
        'image_url' => $settings['image_url'] ?? '',
        'button_text' => $_POST['button_text'] ?? '',
        'button_link' => $buttonLink,
        'button_bg_color' => $_POST['button_bg_color'] ?? '#007bff',
        'display_mode' => $_POST['display_mode'] ?? 'standard',
        'button_text_color' => $_POST['button_text_color'] ?? '#ffffff',


    ];
    if (isset($_FILES['popup_image']) && $_FILES['popup_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['popup_image']['tmp_name'];
        $fileName = basename($_FILES['popup_image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExt, $allowedExts)) {
            $newFileName = uniqid('popup_', true) . '.' . $fileExt;
            $uploadPath = __DIR__ . '/../uploads/images/popup/' . $newFileName;

            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                $newSettings['image_url'] = $newFileName;
            }
        }
    }

    if ($_POST['trigger'] === 'delay') {
        $newSettings['delay'] = isset($_POST['delay']) ? (int) $_POST['delay'] : 5;
    }
    if ($_POST['trigger'] === 'scroll') {
        $newSettings['scroll_percent'] = isset($_POST['scroll_percent']) ? (int) $_POST['scroll_percent'] : 50;
    }

    save_popup_settings($newSettings);
    $settings = $newSettings;
    $message = 'Settings saved successfully.';
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Popup Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="<?= PLUGIN_ROOT ?>admin/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= PLUGIN_ASSETS ?>css/admin-styles.css">
</head>

<body>
    <div class="admin-container">
        <div class="row">
            <div class="col-8">
                <h2 class="mb-4">🛠 Popup Settings</h2>
            </div>
            <div class="col ">
                <img src="popcorn.png" alt="Logo" style="width: 120px; margin-bottom: 20px;">
            </div>
            <?php if ($settings['enabled']): ?>
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?= PLUGIN_ROOT ?>frontend/index.php?page=home" target="_blank" class="btn btn-success col ">🌐 View
                        Home</a>
                    <a href="<?= PLUGIN_ROOT ?>frontend/index.php?page=about" target="_blank" class="btn btn-secondary  col ">ℹ️ View
                        About</a>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($message): ?>
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $message ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Popup Status:</label>
                <select name="enabled" class="form-select" id="enabledSelect" onchange="toggleSettingsPanel()">
                    <option value="1" <?= $settings['enabled'] ? 'selected' : '' ?>>Enabled</option>
                    <option value="0" <?= !$settings['enabled'] ? 'selected' : '' ?>>Disabled</option>
                </select>
            </div>

            <div id="settingsPanel" <?= !$settings['enabled'] ? 'style="display:none;"' : '' ?>>

                <label class="form-label mt-3" title="Select how the popup should be displayed">Display Mode:</label>
                <select name="display_mode" class="form-select" id="displayModeSelect">
                    <option value="standard" <?= ($settings['display_mode'] ?? '') === 'standard' ? 'selected' : '' ?>>🖼 Standard (image + heading + message + button)</option>
                    <option value="background" <?= ($settings['display_mode'] ?? '') === 'background' ? 'selected' : '' ?>>🌄 Background Image with Text</option>
                    <option value="minimal" <?= ($settings['display_mode'] ?? '') === 'minimal' ? 'selected' : '' ?>>🎯 Background Image + Button only</option>
                </select>


                <label class="form-label"
                    title="This is the image, can be placed on top of the button or as background">Upload
                    Image:</label>
                <input type="file" class="form-control" name="popup_image" accept="image/*"
                    onchange="updateImageURL(this)">
                <input type="hidden" name="image_url" id="image_url_field"
                    value="<?= htmlspecialchars($settings['image_url'] ?? '') ?>">


                <?php if (!empty($settings['image_url'])): ?>
                    <img src="<?= PLUGIN_UPLOADS . htmlspecialchars($settings['image_url']) ?>" class="preview-image"
                        alt="Popup Image">
                <?php endif; ?>
                <div class="display-group standard background" id="field-heading">
                    <label class="form-label" title="This is the title shown at the top of the popup">Popup Heading:</label>
                    <input type="text" class="form-control" name="heading"
                        value="<?= htmlspecialchars($settings['heading'] ?? '') ?>">
                </div>
                <div class="display-group standard background" id="field-button-text">
                    <label class="form-label mt-3" title="This is the text inside the CTA button">CTA
                        Button Text:</label>
                    <input type="text" class="form-control" name="button_text"
                        value="<?= htmlspecialchars($settings['button_text'] ?? '') ?>">
                </div>
                <div class="display-group standard background" id="field-message">
                    <label class="form-label" title="This is the text shown below the title">Popup Message:</label>
                    <textarea class="form-control" name="message"
                        rows="3"><?= htmlspecialchars($settings['message'] ?? '') ?></textarea>
                </div>

                <div class="display-group standard minimal" id="field-button-link">
                    <label class="form-label" title="This is the link inside the CTA button">CTA
                        Button Link:</label>
                    <input type="text" class="form-control" name="button_link"
                        value="<?= htmlspecialchars($settings['button_link'] ?? '') ?>">
                </div>

                <div class="display-group standard minimal" id="field-button-bg-color">
                    <label class="form-label" title="This is the background color of  the CTA button">Button Background
                        Color:</label>
                    <input type="color" class="form-control form-control-color" name="button_bg_color"
                        value="<?= htmlspecialchars($settings['button_bg_color'] ?? '#007bff') ?>">
                </div>
                <div class="display-group standard minimal" id="field-button-text-color">
                    <label class="form-label" title="This is the text color of  the CTA button">Button Text
                        Color:</label>
                    <input type="color" class="form-control form-control-color" name="button_text_color"
                        value="<?= htmlspecialchars($settings['button_text_color'] ?? '#ffffff') ?>">
                </div>


                <label class="form-label" title="This is when the popup will appear ">Trigger Type:</label>
                <select class=" form-select" name="trigger" id="triggerSelect" onchange="toggleDelayInput()">
                    <option value="exit-intent" <?= $settings['trigger'] === 'exit-intent' ? 'selected' : '' ?>>Exit
                        Intent</option>
                    <option value="delay" <?= $settings['trigger'] === 'delay' ? 'selected' : '' ?>>Time Delay<span>(on mobile only this trigger applies)</span>
                    </option>
                    <option value="scroll" <?= $settings['trigger'] === 'scroll' ? 'selected' : '' ?>>On scroll
                    </option>
                </select>
                <div id="scrollInput" style="<?= $settings['trigger'] === 'scroll' ? '' : 'display:none;' ?>">
                    <label class="form-label mt-3" title="Scroll % required before popup appears">Scroll Trigger (%)</label>
                    <input type="number" class="form-control" name="scroll_percent" min="1" max="100"
                        value="<?= htmlspecialchars($settings['scroll_percent'] ?? 50) ?>">
                </div>
                <div id="delayInput" style="<?= $settings['trigger'] === 'delay' ? '' : 'display:none;' ?>">
                    <label class="form-label mt-3" title="This is how long until the popup appears">Delay (in
                        seconds):</label>
                    <input type="number" class="form-control" name="delay" min="1"
                        value="<?= htmlspecialchars($settings['delay'] ?? 5) ?>">
                </div>

                <label class="form-label mt-3" title="This is the cookie duration of the popup in days">Cookie Duration
                    (in
                    days):</label>
                <input type="number" class="form-control" name="cookie_duration" min="1"
                    value="<?= htmlspecialchars($settings['cookie_duration'] ?? 1) ?>">

            </div>
            <label class="form-label mt-3" title="Select which page(s) to show the popup on">Show on Page(s):</label>
            <select name="target_page" class="form-select">
                <option value="all" <?= ($settings['target_page'] ?? '') === 'all' ? 'selected' : '' ?>>All Pages
                </option>
                <option value="home" <?= ($settings['target_page'] ?? '') === 'home' ? 'selected' : '' ?>>
                    Homepage</option>
                <option value="about" <?= ($settings['target_page'] ?? '') === 'about' ? 'selected' : '' ?>>About Page
                </option>
            </select>


            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">💾 Save Settings</button>
                <button type="button" class="btn btn-outline-secondary" onclick="openPreview()">👁 Preview</button>

            </div>

        </form>
    </div>
    <!-- Live Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" style="max-width: 500px;">
            <div class="modal-content p-0 border-0">
                <div class="modal-body p-0" style="height: 600px;">
                    <iframe id="previewFrame" src="" frameborder="0"
                        style="width:100%; height:100%; border:none;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateDisplayModeFields() {
            const mode = document.getElementById('displayModeSelect').value;

            const fields = {
                heading: document.getElementById('field-heading'),
                message: document.getElementById('field-message'),
                buttonText: document.getElementById('field-button-text'),
                buttonLink: document.getElementById('field-button-link'),
                buttonBgColor: document.getElementById('field-button-bg-color'),
                buttonTextColor: document.getElementById('field-button-text-color')
            };

            for (const key in fields) {
                if (fields[key]) fields[key].style.display = 'none';
            }

            if (mode === 'standard') {
                fields.heading.style.display = 'block';
                fields.message.style.display = 'block';
                fields.buttonText.style.display = 'block';
                fields.buttonLink.style.display = 'block';
                fields.buttonBgColor.style.display = 'block';
                fields.buttonTextColor.style.display = 'block';
            } else if (mode === 'background') {
                fields.buttonLink.style.display = 'block';
            } else if (mode === 'minimal') {
                fields.buttonText.style.display = 'block';
                fields.buttonLink.style.display = 'block';
                fields.buttonBgColor.style.display = 'block';
                fields.buttonTextColor.style.display = 'block';
            }
        }

        document.addEventListener('DOMContentLoaded', updateDisplayModeFields);
        document.getElementById('displayModeSelect').addEventListener('change', updateDisplayModeFields);
    </script>


    <script src="<?= PLUGIN_ASSETS ?>js/admin-scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>