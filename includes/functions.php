<?php
function get_popup_settings() {
    $path = __DIR__ . '/../config/settings.json';
    if (!file_exists($path)) return [];
    return json_decode(file_get_contents($path), true);
}

function save_popup_settings($data) {
    $path = __DIR__ . '/../config/settings.json';
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
}