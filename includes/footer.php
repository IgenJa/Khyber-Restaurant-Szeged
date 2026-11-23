    </main>

    <footer class="site-footer">
        <div class="container site-footer__grid">
            <div class="site-footer__brand">
                <a class="logo" href="#home">
                    <span class="logo__name">Khyber</span>
                    <span class="logo__meta">Restaurant</span>
                </a>
                <p><?= e($t['footer']['blurb']) ?></p>
            </div>

            <nav class="site-footer__nav" aria-label="<?= e($t['nav']['primary']) ?>">
                <a href="#home"><?= e($t['nav']['home']) ?></a>
                <a href="#about"><?= e($t['nav']['about']) ?></a>
                <a href="#menu"><?= e($t['nav']['menu']) ?></a>
                <a href="#contact"><?= e($t['nav']['contact']) ?></a>
            </nav>

            <div class="site-footer__contact">
                <p><?= e($restaurantName) ?></p>
                <?php if ($address !== ''): ?>
                    <p><?= e($address) ?></p>
                <?php endif; ?>
                <p><?= e($t['contact']['location']) ?></p>
                <?php if ($phoneHref !== null): ?>
                    <p><a href="<?= e($phoneHref) ?>"><?= e($config['phone']) ?></a></p>
                <?php endif; ?>
                <?php if ($emailOk): ?>
                    <p><a href="mailto:<?= e(trim($config['email'])) ?>"><?= e(trim($config['email'])) ?></a></p>
                <?php endif; ?>
                <?php if ($hours !== ''): ?>
                    <p><?= nl2br(e($hours), false) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="site-footer__bar">
            <div class="container">
                <p>&copy; <?= e(date('Y')) ?> <?= e($restaurantName) ?>. <?= e($t['footer']['rights']) ?></p>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
