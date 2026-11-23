(function () {
    var header = document.querySelector('[data-header]');
    var nav = document.querySelector('[data-nav]');
    var toggle = document.querySelector('[data-nav-toggle]');
    var label = document.querySelector('[data-nav-label]');
    var desktop = window.matchMedia('(min-width: 1041px)');

    if (!header || !nav || !toggle) {
        return;
    }

    function setOpen(open) {
        nav.classList.toggle('is-open', open);
        header.classList.toggle('is-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.classList.toggle('nav-open', open);

        if (label) {
            label.textContent = open
                ? toggle.getAttribute('data-label-close')
                : toggle.getAttribute('data-label-open');
        }

        if (!desktop.matches) {
            nav.setAttribute('aria-hidden', open ? 'false' : 'true');
        }
    }

    function syncLayout() {
        if (desktop.matches) {
            setOpen(false);
            nav.removeAttribute('aria-hidden');
            return;
        }

        if (toggle.getAttribute('aria-expanded') !== 'true') {
            nav.setAttribute('aria-hidden', 'true');
        }
    }

    toggle.addEventListener('click', function () {
        setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    nav.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (!desktop.matches) {
                setOpen(false);
            }
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            setOpen(false);
        }
    });

    var sections = Array.prototype.slice.call(document.querySelectorAll('main section[id]'));
    var links = Array.prototype.slice.call(nav.querySelectorAll('a[href^="#"]'));

    function markSection() {
        var line = window.scrollY + header.offsetHeight + 32;
        var current = sections[0];

        sections.forEach(function (section) {
            if (section.offsetTop <= line) {
                current = section;
            }
        });

        if (!current) {
            return;
        }

        links.forEach(function (link) {
            if (link.getAttribute('href') === '#' + current.id) {
                link.setAttribute('aria-current', 'true');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    }

    function onScroll() {
        header.classList.toggle('is-scrolled', window.scrollY > 16);
        markSection();
    }

    var motion = window.matchMedia('(prefers-reduced-motion: reduce)');

    if (!motion.matches && 'IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) {
                    return;
                }
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.16, rootMargin: '0px 0px -8% 0px' });

        document.querySelectorAll('.reveal').forEach(function (el) {
            observer.observe(el);
        });
    } else {
        document.querySelectorAll('.reveal').forEach(function (el) {
            el.classList.add('is-visible');
        });
    }

    if (typeof desktop.addEventListener === 'function') {
        desktop.addEventListener('change', syncLayout);
    }

    syncLayout();
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
}());
