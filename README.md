# public_html

A PHP-based coupon and discount code website — likely powering **grabdiscountcodes.com** or a similar platform.

---

## 🗂️ Project Overview

This is a full-stack web application that allows users to browse stores, categories, coupon types, and discount codes. It includes an admin panel, AJAX support, multi-language handling, and SEO-ready features like sitemaps and robots.txt.

---

## 🛠️ Tech Stack

| Layer      | Technology              |
|------------|-------------------------|
| Backend    | PHP (69%)               |
| Frontend   | JavaScript, CSS (30%)   |
| Database   | MySQL (via raw queries) |
| Server     | Apache (`.htaccess`)    |

---

## 📁 Folder Structure

```
public_html/
├── admin/              # Admin panel
├── ajax/               # AJAX request handlers
├── assets/             # Images, icons, and static assets
├── backups/            # Database/file backups
├── classes/            # PHP classes (e.g., DB_Sql, common functions)
├── coupon2/            # Coupon-related module (v2)
├── files/              # Uploaded files (banners, images)
├── fonts/              # Custom fonts
├── include/            # Shared PHP includes
├── js/                 # JavaScript files
├── lang/               # Language files (multi-language support)
├── owl.carousel/       # Owl Carousel slider library
├── predefinedpages/    # Page templates (store detail, category, search, etc.)
├── sessions/           # Session storage
├── testt/              # Test/dev files
├── ttemplate/          # Additional templates
├── verify/             # Verification pages
├── wpp/                # Extra module/plugin folder
│
├── index.php           # Main entry point (URL router)
├── template.php        # Global layout/template loader
├── home.php            # Homepage
├── ajax_functions.php  # AJAX handler functions
├── cronjobs.php        # Scheduled task scripts
├── sendemails.php      # Email sending logic
├── composemail.php     # Email composition helper
├── barcode.php         # Barcode generation
├── logout.php          # User logout
├── sitemap.xml         # SEO sitemap
├── robots.txt          # Search engine rules
├── ads.txt             # Ads.txt for ad network authorization
├── .htaccess           # URL rewriting & server config
├── php.ini             # PHP config overrides
└── coupon5s.sql        # Database schema/dump
```

---

## ⚙️ How It Works

The site uses a single-entry routing pattern via `index.php`. URL parameters (`option`, `url`, `suboption`) determine which page template is loaded from the `predefinedpages/` folder.

Key routes include:

- `/` → Homepage
- `?option=store&url=store-name` → Store detail page
- `?option=category&url=cat-name` → Category listing
- `?option=coupon` → Coupon listing
- `?option=policy&url=page-slug` → Static/policy pages
- `?option=search1&q=...` → Search results
- `?option=expire-coupon` → Expired coupons

---

## 🚀 Getting Started

### Requirements

- PHP 7.x or 8.x
- MySQL / MariaDB
- Apache with `mod_rewrite` enabled

### Setup

1. Clone or upload files to your web server's `public_html` directory.
2. Import the database using `coupon5s.sql`.
3. Configure database credentials in `classes/commonfunctions.php` (or the relevant config file).
4. Make sure `mod_rewrite` is enabled and `.htaccess` is allowed.
5. Set correct file permissions on `files/`, `sessions/`, and `backups/`.

---

## 🌐 Multi-Language Support

Language files are stored in the `lang/` folder (e.g., `en.php`). The active language is stored in the session (`$_SESSION['Frontendlanguage']`) and defaults to English (`en`).

---

## 🔒 Notes

- The `error_log` file is committed — consider adding it to `.gitignore`.
- Sensitive files like `check_samad_password.php` and `coupon5s.sql` should be reviewed before deploying to production.
- The search function uses `eregi_replace` (deprecated in PHP 7+) — consider updating to `preg_replace`.

---

## 📄 License

This project does not currently include a license file.
