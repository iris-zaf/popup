# 🎉 PHP Smart Exit-Intent Popup Plugin

An easy-to-integrate, customizable popup plugin for any PHP website. Show popups on exit intent or delay — perfect for announcements, CTAs, newsletter captures, and more.

---

## ✨ Features

- 💨 Exit-Intent or Time Delay Triggers
- ⚙️ Easy Admin Settings Panel
- 🎯 Target Specific Pages (home, about, etc.)
- 📦 JSON-based Settings for Portability
- 🎨 Customizable Image, CTA Button, and Colors
- 🧠 Cookie-based display control
- 🔐 Safe Uploads & Validations

---

## 📁 Folder Structure
popup/
├── admin/ # Admin panel files
├── assets/ # CSS and JS
├── config/ # Config files & settings.json
├── frontend/ # User-facing pages
├── includes/ # Utility PHP functions
├── uploads/ # Image uploads
├── views/ # Popup modal template
├── index.php # Optional landing page (portfolio style)
├── README.md
└── LICENSE.txt

## 🚀 Getting Started

### 1. Copy Files

Upload the entire `popup/` folder to your server directory (e.g., inside `htdocs` or `public_html`).

### 2. Access Admin Panel

Visit:  http://localhost/popup/admin/index.php

You’ll see a UI for:
- Enabling/disabling the popup
- Choosing trigger type
- Selecting the target page (e.g. home, about- these two are provided for showcasing purposes)
- Uploading an image
- Adding CTA button text, colors, and links

### 3. Add to Your Site

Use the provided `frontend/index.php?page=home` or `?page=about` pattern to load your views.

### 4. Customization

- Edit `views/popup-view.php` to change popup layout.
- Modify styles in `assets/css/frontend-styles.css`.

---

## 🔧 Configuration

Settings are saved in `config/settings.json`. You can manually edit or export/import this file.

Example:
```json
{
  "enabled": true,
  "trigger": "exit-intent",
  "cookie_duration": 3,
  "heading": "Don't leave yet!",
  "message": "Get a 10% discount if you stay!",
  "target_page": "home",
  "image_url": "popup_123abc.jpg",
  "button_text": "Grab Offer",
  "button_link": "https://yourlink.com",
  "button_bg_color": "#e23d32",
  "button_text_color": "#ffffff"
}

📌 Notes
This plugin does not require any framework (pure PHP).

Tested on Apache with PHP 7.4+.

Compatible with local development (XAMPP, MAMP, etc).

🙌 Author
Developed by Iris Kalogirou
For support, contact  iriskalogirou1@gmail.com
