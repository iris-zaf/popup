<?php
require_once __DIR__ . '/../config/config.php';

function get_popup_settings($page = null)
{
    global $mongoDb;
    $collection = $mongoDb->selectCollection('popup_settings');

    $settings = $collection->findOne(['target_page' => $page]);
    if ($page) {
        $settings = $collection->findOne(['target_page' => $page]);
        if (!$settings) {
            // fallback if not exists
            $settings = $collection->findOne(['target_page' => 'all']);
        }
    } else {
        $settings = $collection->findOne(['target_page' => 'all']);
    }
    $defaults = [
        'enabled' => false,
        'trigger' => 'exit-intent',
        'delay' => 5,
        'scroll_percent' => 50,
        'cookie_duration' => 1,
        'heading' => '',
        'message' => '',
        'target_page' => 'all',
        'image_url' => '',
        'button_text' => '',
        'button_link' => '',
        'button_bg_color' => '#007bff',
        'button_text_color' => '#ffffff',
        'display_mode' => 'standard',
    ];

    return array_merge($defaults, (array) $settings);
}

function save_popup_settings($data, $originalPage = null)
{
    global $mongoDb;
    $collection = $mongoDb->selectCollection('popup_settings');

    $newPage = $data['target_page'] ?? 'all';

    // Check for conflict only if the page was changed
    if ($originalPage !== null && $originalPage !== $newPage) {
        $existing = $collection->findOne(['target_page' => $newPage]);
        if ($existing) {
            throw new Exception("A popup for the page '$newPage' already exists.");
        }
    }

    $document = [
        'enabled' => $data['enabled'] ?? false,
        'trigger' => $data['trigger'] ?? null,
        'delay' => $data['delay'] ?? null,
        'scroll_percent' => $data['scroll_percent'] ?? null,
        'cookie_duration' => $data['cookie_duration'] ?? 1,
        'heading' => $data['heading'] ?? '',
        'message' => $data['message'] ?? '',
        'target_page' => $newPage,
        'image_url' => $data['image_url'] ?? '',
        'button_text' => $data['button_text'] ?? '',
        'button_link' => $data['button_link'] ?? '',
        'button_bg_color' => $data['button_bg_color'] ?? '#007bff',
        'button_text_color' => $data['button_text_color'] ?? '#ffffff',
        'display_mode' => $data['display_mode'] ?? 'standard'
    ];
    $filter = ['target_page' => $originalPage ?: $newPage];

    $collection->updateOne(
        $filter,
        ['$set' => $document],
        ['upsert' => true]
    );
}

function render_popup_view($page = null)
{
    $settings = get_popup_settings($page);
    include __DIR__ . '/../views/popup-view.php';
}
// Get all popups
function get_all_popups()
{
    global $mongoDb;
    return $mongoDb->popup_settings->find()->toArray();
}
