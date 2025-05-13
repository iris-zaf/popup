<?php
require_once __DIR__ . '/includes/functions.php';
$settings = get_popup_settings();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Popup Test Page</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #fdfdfd;
            margin: 0;
            padding: 0;
        }

        #popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 999;
            backdrop-filter: blur(3px);
        }

        #popup {
            display: none;
            position: fixed;
            width: 320px;
            max-width: 90%;
            padding: 25px 20px;
            background: #ffffff;
            border-radius: 12px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            text-align: center;
            animation: popupFadeIn 0.3s ease-out forwards;
        }


        @keyframes popupFadeIn {
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        #popup p {
            font-size: 16px;
            margin-bottom: 20px;
        }

        #popup button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        #popup img {
            border-radius: 10px;
            max-width: 100%;
            margin-bottom: 20px;
        }

        #popup h3 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        #popup p {
            font-size: 15px;
            color: #555;
            margin-bottom: 20px;
        }

        #popup a.btn {
            font-weight: 500;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
        }

        #popup button:hover {
            background-color: #0056b3;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            margin-top: 10px;
            transition: background-color 0.2s ease;
        }

        #popup-close {
            position: absolute;
            top: 12px;
            right: 16px;
            font-size: 22px;
            font-weight: bold;
            color: #888;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        #popup-close:hover {
            color: #000;
        }
    </style>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container my-auto text-center py-5">
        <div class="card shadow-lg p-4 mx-auto" style="max-width: 600px;">
            <h1 class="card-title mb-3">🎉 Welcome to the Popup Test Page</h1>
            <p class="card-text">This is a demo page to showcase how your popup plugin works.</p>
            <p class="text-muted">You can trigger the popup by <strong>exit intent</strong> or after a <strong>time
                    delay</strong>, depending on your settings.</p>
        </div>
    </div>


    <div id="popup-overlay"></div>
    <div id="popup">
        <span id="popup-close" onclick="closePopup()">×</span>
        <?php if (!empty($settings['image_url'])): ?>
            <img src="/popup-plugin/uploads/<?= htmlspecialchars($settings['image_url']) ?>" alt="Popup Image"
                class="img-fluid rounded mb-3">
        <?php endif; ?>


        <?php if (!empty($settings['heading'])): ?>
            <h3><?= htmlspecialchars($settings['heading']) ?></h3>
        <?php endif; ?>

        <?php if (!empty($settings['message'])): ?>
            <p><?= nl2br(htmlspecialchars($settings['message'])) ?></p>
        <?php endif; ?>

        <?php if (!empty($settings['button_text']) && !empty($settings['button_link'])): ?>
            <a href="<?= htmlspecialchars($settings['button_link']) ?>" class="btn" target="_blank" style="background-color: <?= htmlspecialchars($settings['button_bg_color'] ?? '#007bff') ?>; 
          color: <?= htmlspecialchars($settings['button_text_color'] ?? '#ffffff') ?>;">
                <?= htmlspecialchars($settings['button_text']) ?>
            </a>

        <?php endif; ?>

    </div>

    <script>
        const settings = <?= json_encode($settings) ?>;

        function getCookie(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        }

        function setCookie(name, value, days) {
            const expires = new Date(Date.now() + days * 86400000).toUTCString();
            document.cookie = `${name}=${value}; expires=${expires}; path=/`;
        }

        function showPopup() {

            if (getCookie('popup_shown')) return;
            document.getElementById('popup').style.display = 'block';
            document.getElementById('popup-overlay').style.display = 'block';
            setCookie('popup_shown', '1', settings.cookie_duration || 1);
        }

        function closePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('popup-overlay').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (!settings.enabled) return;

            if (settings.trigger === 'delay') {
                const delayTime = settings.delay ? settings.delay : 5;
                setTimeout(showPopup, delayTime * 1000);
            }


            if (settings.trigger === 'exit-intent') {
                document.addEventListener('mouseleave', (e) => {
                    if (e.clientY < 0) {
                        showPopup();
                    }
                });
            }
        });
    </script>

</body>

</html>