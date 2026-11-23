<?php

declare(strict_types=1);

$config = require __DIR__ . '/config.php';

$allowedLangs = ['hu', 'en'];
$lang = 'hu';

if (isset($_GET['lang']) && in_array($_GET['lang'], $allowedLangs, true)) {
    $lang = $_GET['lang'];
    setcookie('khyber_lang', $lang, [
        'expires' => time() + 60 * 60 * 24 * 365,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
} elseif (isset($_COOKIE['khyber_lang']) && in_array($_COOKIE['khyber_lang'], $allowedLangs, true)) {
    $lang = $_COOKIE['khyber_lang'];
}

$t = require __DIR__ . '/lang/' . $lang . '.php';

/**
 * Dish photos. Replace the files in assets/images and keep these names.
 */
$images = [
    'hero' => 'assets/images/hero.jpg',
    'about' => 'assets/images/about.jpg',
    'samosa' => 'assets/images/samosa.jpg',
    'daal' => 'assets/images/daal.jpg',
    'biryani' => 'assets/images/biryani.jpg',
    'gulab' => 'assets/images/gulab-jamun.jpg',
    'lassi' => 'assets/images/mango-lassi.jpg',
];

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function site_url(string $path, array $config): string
{
    $base = rtrim((string) ($config['site_url'] ?? ''), '/');
    $path = ltrim($path, '/');

    if ($base === '') {
        return $path;
    }

    return $base . '/' . $path;
}

function image_src(string $path): string
{
    if ($path !== '' && is_file(__DIR__ . '/' . $path)) {
        return $path;
    }

    return '';
}

function phone_href(string $phone): ?string
{
    $phone = trim($phone);
    if ($phone === '') {
        return null;
    }

    $normalized = preg_replace('/[^\d+]/', '', $phone);
    if (!is_string($normalized) || !preg_match('/^\+?[0-9]{7,15}$/', $normalized)) {
        return null;
    }

    return 'tel:' . $normalized;
}

function maps_embed_url(string $url): string
{
    $url = trim($url);
    if ($url === '' || preg_match('/\s/', $url)) {
        return '';
    }

    $parts = parse_url($url);
    if (!is_array($parts)) {
        return '';
    }

    $scheme = strtolower((string) ($parts['scheme'] ?? ''));
    $host = strtolower((string) ($parts['host'] ?? ''));
    $path = (string) ($parts['path'] ?? '');
    $allowedHosts = ['www.google.com', 'google.com', 'maps.google.com'];

    if ($scheme !== 'https' || !in_array($host, $allowedHosts, true)) {
        return '';
    }

    if (!str_starts_with($path, '/maps')) {
        return '';
    }

    return $url;
}

function icon(string $name): string
{
    $svg = [
        'bowl' => '<svg viewBox="0 0 32 32" aria-hidden="true" focusable="false"><path d="M6 13h20"/><path d="M8.2 13c.5 6 3.6 9.5 7.8 9.5s7.3-3.5 7.8-9.5"/><path d="M16 7v3.2"/></svg>',
        'spice' => '<svg viewBox="0 0 32 32" aria-hidden="true" focusable="false"><path d="M16 4.8l1.7 5.1 5.4.1-4.3 3.3 1.6 5.2L16 18.4l-4.4 3.1 1.6-5.2-4.3-3.3 5.4-.1z"/></svg>',
        'halal' => '<svg viewBox="0 0 32 32" aria-hidden="true" focusable="false"><path d="M18.5 7.2a8.4 8.4 0 1 0 .2 17.5 6.5 6.5 0 1 1-.2-17.5z"/></svg>',
        'pin' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 21s6-5.2 6-10a6 6 0 1 0-12 0c0 4.8 6 10 6 10z"/><circle cx="12" cy="11" r="1.7"/></svg>',
        'phone' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M8.2 4.8h2.2l1.2 3-1.6 1a12 12 0 0 0 5.2 5.2l1-1.6 3 1.2v2.2c0 .7-.5 1.3-1.2 1.4A14.5 14.5 0 0 1 6.8 6c.1-.7.7-1.2 1.4-1.2z"/></svg>',
        'mail' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="3.5" y="5.5" width="17" height="13"/><path d="M4 6.5l8 7 8-7"/></svg>',
        'clock' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="8"/><path d="M12 8v4.5l3 2"/></svg>',
        'mark' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 3.5 20 12 12 20.5 4 12z"/></svg>',
    ];

    return $svg[$name] ?? '';
}

$restaurantName = trim((string) ($config['restaurant_name'] ?? 'Khyber Restaurant Szeged'));
$phoneHref = phone_href((string) ($config['phone'] ?? ''));
$email = trim((string) ($config['email'] ?? ''));
$emailOk = filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
$address = trim((string) ($config['address'] ?? ''));
$hoursMap = $config['opening_hours'] ?? [];
$hours = is_array($hoursMap) ? trim((string) ($hoursMap[$lang] ?? '')) : '';

$directionsHref = null;
$mapEmbed = '';

if (strlen($address) >= 5) {
    $directionsHref = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($address);
    $customMap = maps_embed_url((string) ($config['maps_embed_url'] ?? ''));
    $mapEmbed = $customMap !== ''
        ? $customMap
        : 'https://maps.google.com/maps?q=' . rawurlencode($address) . '&z=16&output=embed';
}

$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Restaurant',
    'name' => $restaurantName,
    'servesCuisine' => ['Pakistani', 'Indian'],
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Szeged',
        'addressCountry' => 'HU',
    ],
];

if ($address !== '') {
    $schema['address']['streetAddress'] = $address;
}
if ($phoneHref !== null) {
    $schema['telephone'] = trim((string) $config['phone']);
}
if ($emailOk) {
    $schema['email'] = $email;
}
if ($config['site_url'] ?? '') {
    $schema['url'] = rtrim((string) $config['site_url'], '/');
}

$schemaJson = json_encode(
    $schema,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP
);

require __DIR__ . '/includes/header.php';
?>

        <section class="hero" id="home">
            <div class="hero__media">
                <img src="<?= e($images['hero']) ?>" alt="<?= e($t['hero']['image_alt']) ?>" width="1800" height="1200" fetchpriority="high">
                <div class="hero__shade"></div>
            </div>
            <div class="container hero__content">
                <p class="eyebrow"><?= e($t['hero']['eyebrow']) ?></p>
                <h1><?= e($t['hero']['title']) ?> <span><?= e($t['hero']['title_line']) ?></span></h1>
                <p class="hero__subtitle"><?= e($t['hero']['subtitle']) ?></p>
                <p class="hero__lead"><?= e($t['hero']['description']) ?></p>
                <div class="hero__actions">
                    <a class="btn btn--primary" href="#menu"><?= e($t['hero']['menu']) ?></a>
                    <a class="btn btn--ghost" href="#contact"><?= e($t['hero']['contact']) ?></a>
                </div>
            </div>
        </section>

        <section class="about" id="about">
            <div class="container about__grid">
                <figure class="about__photo reveal">
                    <img src="<?= e($images['about']) ?>" alt="<?= e($t['about']['image_alt']) ?>" width="1200" height="1500" loading="lazy" decoding="async">
                </figure>
                <div class="about__copy reveal">
                    <p class="eyebrow"><?= e($t['about']['label']) ?></p>
                    <h2><?= e($t['about']['heading']) ?></h2>
                    <?php foreach ($t['about']['paragraphs'] as $paragraph): ?>
                        <p><?= e($paragraph) ?></p>
                    <?php endforeach; ?>
                    <ul class="features">
                        <?php foreach ($t['about']['features'] as $feature): ?>
                            <li>
                                <?= icon((string) $feature['icon']) ?>
                                <span><?= e($feature['title']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </section>

        <section class="menu" id="menu">
            <div class="container">
                <header class="section-head reveal">
                    <p class="eyebrow"><?= e($t['menu']['label']) ?></p>
                    <h2><?= e($t['menu']['heading']) ?></h2>
                    <p class="section-intro"><?= e($t['menu']['intro']) ?></p>
                    <p class="menu__notice"><?= e($t['menu']['notice']) ?></p>
                </header>
                <ul class="menu-grid">
                    <?php foreach ($t['menu']['items'] as $item): ?>
                        <?php $photo = image_src($images[$item['id']] ?? ''); ?>
                        <li class="reveal">
                            <article class="dish">
                                <div class="dish__media">
                                    <?php if ($photo !== ''): ?>
                                        <img src="<?= e($photo) ?>" alt="<?= e($item['alt']) ?>" width="1000" height="750" loading="lazy" decoding="async">
                                    <?php endif; ?>
                                </div>
                                <div class="dish__body">
                                    <p class="dish__category"><?= e($item['category']) ?></p>
                                    <h3><?= e($item['name']) ?></h3>
                                    <p><?= e($item['description']) ?></p>
                                </div>
                            </article>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>

        <section class="contact" id="contact">
            <div class="container contact__grid">
                <div class="contact__copy reveal">
                    <p class="eyebrow"><?= e($t['contact']['label']) ?></p>
                    <h2><?= e($t['contact']['heading']) ?></h2>
                    <p><?= e($t['contact']['description']) ?></p>

                    <ul class="details">
                        <li>
                            <?= icon('mark') ?>
                            <span><?= e($restaurantName) ?></span>
                        </li>
                        <li>
                            <?= icon('pin') ?>
                            <span><?= e($t['contact']['location']) ?></span>
                        </li>
                        <?php if ($address !== ''): ?>
                            <li>
                                <?= icon('pin') ?>
                                <span><?= e($address) ?></span>
                            </li>
                        <?php endif; ?>
                        <?php if ($phoneHref !== null): ?>
                            <li>
                                <?= icon('phone') ?>
                                <a href="<?= e($phoneHref) ?>"><?= e(trim((string) $config['phone'])) ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if ($emailOk): ?>
                            <li>
                                <?= icon('mail') ?>
                                <a href="mailto:<?= e($email) ?>"><?= e($email) ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if ($hours !== ''): ?>
                            <li>
                                <?= icon('clock') ?>
                                <span><?= nl2br(e($hours), false) ?></span>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <div class="contact__actions">
                        <?php if ($directionsHref !== null): ?>
                            <a class="btn btn--primary" href="<?= e($directionsHref) ?>" target="_blank" rel="noopener noreferrer"><?= e($t['contact']['directions']) ?></a>
                        <?php else: ?>
                            <button class="btn btn--primary" type="button" disabled><?= e($t['contact']['directions']) ?></button>
                        <?php endif; ?>

                        <?php if ($phoneHref !== null): ?>
                            <a class="btn btn--line" href="<?= e($phoneHref) ?>"><?= e($t['contact']['call']) ?></a>
                        <?php else: ?>
                            <button class="btn btn--line" type="button" disabled><?= e($t['contact']['call']) ?></button>
                        <?php endif; ?>
                    </div>

                    <?php if ($directionsHref === null || $phoneHref === null): ?>
                        <div class="contact__notes">
                            <?php if ($directionsHref === null): ?>
                                <p><?= e($t['contact']['note_address']) ?></p>
                            <?php endif; ?>
                            <?php if ($phoneHref === null): ?>
                                <p><?= e($t['contact']['note_phone']) ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="contact__map reveal">
                    <?php if ($mapEmbed !== ''): ?>
                        <iframe
                            src="<?= e($mapEmbed) ?>"
                            title="<?= e($t['contact']['map_title']) ?>"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen
                        ></iframe>
                    <?php else: ?>
                        <div class="map-placeholder">
                            <?= icon('pin') ?>
                            <p><?= e($t['contact']['map_placeholder']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

<?php require __DIR__ . '/includes/footer.php'; ?>
