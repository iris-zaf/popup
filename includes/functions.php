<?php
require_once __DIR__ . '/../config/config.php';

function get_popup_settings()
{
    global $mongoDb;
    $collection = $mongoDb->selectCollection('popup_settings');

    $settings = $collection->findOne(['_id' => 'main_settings']);

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

function save_popup_settings($data)
{
    global $mongoDb;

    $collection = $mongoDb->selectCollection('popup_settings');

    // Prepare the document with default values
    $document = [
        '_id' => 'main_settings',
        'enabled' => $data['enabled'] ?? false,
        'trigger' => $data['trigger'] ?? null,
        'delay' => $data['delay'] ?? null,
        'scroll_percent' => $data['scroll_percent'] ?? null,
        'cookie_duration' => $data['cookie_duration'] ?? 1,
        'heading' => $data['heading'] ?? '',
        'message' => $data['message'] ?? '',
        'target_page' => $data['target_page'] ?? 'all',
        'image_url' => $data['image_url'] ?? '',
        'button_text' => $data['button_text'] ?? '',
        'button_link' => $data['button_link'] ?? '',
        'button_bg_color' => $data['button_bg_color'] ?? '#007bff',
        'button_text_color' => $data['button_text_color'] ?? '#ffffff',
        'display_mode' => $data['display_mode'] ?? 'standard'
    ];

    // Use updateOne with upsert to create/update the single settings document.
    // If a document with _id 'main_settings' exists, it updates it. If not, it inserts it.
    $collection->updateOne(
        ['_id' => 'main_settings'],
        ['$set' => $document],
        ['upsert' => true]
    );
}
