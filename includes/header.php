<?php

$huUrl = site_url('index.php?lang=hu', $config);
$enUrl = site_url('index.php?lang=en', $config);
$canonical = site_url('index.php?lang=' . $lang, $config);
$ogImage = site_url($images['hero'], $config);
$otherLocale = $lang === 'hu' ? 'en_GB' : 'hu_HU';

?><!DOCTYPE html>
<html lang="<?= e($lang) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($t['meta']['title']) ?></title>
    <meta name="description" content="<?= e($t['meta']['description']) ?>">
    <meta name="theme-color" content="#171717">
    <link rel="canonical" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="hu" href="<?= e($huUrl) ?>">
    <link rel="alternate" hreflang="en" href="<?= e($enUrl) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= e($huUrl) ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="<?= e($t['meta']['og_locale']) ?>">
    <meta property="og:locale:alternate" content="<?= e($otherLocale) ?>">
    <meta property="og:title" content="<?= e($t['meta']['title']) ?>">
    <meta property="og:description" content="<?= e($t['meta']['description']) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">
    <meta property="og:image:alt" content="<?= e($t['hero']['image_alt']) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($t['meta']['title']) ?>">
    <meta name="twitter:description" content="<?= e($t['meta']['description']) ?>">
    <meta name="twitter:image" content="<?= e($ogImage) ?>">
    <script>document.documentElement.classList.add('js');</script>
    <link rel="icon" href="assets/images/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;1,500&display=swap" rel="stylesheet">
    <link rel="preload" as="image" href="<?= e($images['hero']) ?>">
    <link rel="stylesheet" href="assets/css/style.css">
    <script type="application/ld+json"><?= $schemaJson ?></script>
</head>
<body>
    <a class="skip-link" href="#main"><?= e($t['nav']['skip']) ?></a>

    <header class="site-header" data-header>
        <div class="container site-header__bar">
            <a class="logo" href="#home">
                <span class="logo__name">Khyber</span>
                <span class="logo__meta">Restaurant</span>
            </a>

            <nav class="site-nav" id="site-nav" aria-label="<?= e($t['nav']['primary']) ?>" data-nav>
                <a href="#home"><?= e($t['nav']['home']) ?></a>
                <a href="#about"><?= e($t['nav']['about']) ?></a>
                <a href="#menu"><?= e($t['nav']['menu']) ?></a>
                <a href="#contact"><?= e($t['nav']['contact']) ?></a>
            </nav>

            <div class="site-header__tools">
                <div class="lang" aria-label="<?= e($t['nav']['language']) ?>">
                    <a href="index.php?lang=hu" lang="hu" hreflang="hu"<?= $lang === 'hu' ? ' class="is-active" aria-current="true"' : '' ?>>HU</a>
                    <span aria-hidden="true">|</span>
                    <a href="index.php?lang=en" lang="en" hreflang="en"<?= $lang === 'en' ? ' class="is-active" aria-current="true"' : '' ?>>EN</a>
                </div>
                <button
                    class="nav-toggle"
                    type="button"
                    aria-expanded="false"
                    aria-controls="site-nav"
                    data-nav-toggle
                    data-label-open="<?= e($t['nav']['open']) ?>"
                    data-label-close="<?= e($t['nav']['close']) ?>"
                >
                    <span class="nav-toggle__bars" aria-hidden="true"></span>
                    <span class="visually-hidden" data-nav-label><?= e($t['nav']['open']) ?></span>
                </button>
            </div>
        </div>
    </header>
    <main id="main">
