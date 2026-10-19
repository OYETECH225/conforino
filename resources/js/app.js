import './bootstrap';

// Navigation par ancre gérée manuellement : le saut natif du navigateur vers
// un fragment (#id) s'est révélé peu fiable sur ce projet (arrêt prématuré
// du scroll), donc on prend la main nous-mêmes avec scrollIntoView.
document.addEventListener('click', (event) => {
    const link = event.target.closest('a[href^="#"]');

    if (!link) {
        return;
    }

    const id = link.getAttribute('href').slice(1);
    const target = id ? document.getElementById(id) : null;

    if (!target) {
        return;
    }

    event.preventDefault();
    target.scrollIntoView({ behavior: 'instant', block: 'start' });
    history.pushState(null, '', `#${id}`);
});

// Apparition discrète au scroll : ajoute .is-visible aux éléments .reveal
// quand ils entrent dans le viewport (une seule fois, pas d'aller-retour).
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const revealTargets = document.querySelectorAll('.reveal');

if (prefersReducedMotion || !('IntersectionObserver' in window)) {
    revealTargets.forEach((el) => el.classList.add('is-visible'));
} else {
    const revealObserver = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
    );

    revealTargets.forEach((el) => revealObserver.observe(el));
}

// Compteur animé pour les chiffres clés (ex: "200+", "13 ans") : ne s'anime
// que la partie numérique de départ, le reste du texte (unité, +) est affiché
// tel quel pour ne jamais afficher une valeur inventée.
const countTargets = document.querySelectorAll('[data-count-to]');

if (countTargets.length && !prefersReducedMotion && 'IntersectionObserver' in window) {
    const countObserver = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) {
                    return;
                }

                const el = entry.target;
                const end = parseInt(el.dataset.countTo, 10);
                const suffix = el.dataset.countSuffix || '';
                const duration = 900;
                const start = performance.now();

                const step = (now) => {
                    const progress = Math.min((now - start) / duration, 1);
                    const eased = 1 - Math.pow(1 - progress, 3);
                    el.textContent = Math.round(end * eased) + suffix;

                    if (progress < 1) {
                        requestAnimationFrame(step);
                    }
                };

                requestAnimationFrame(step);
                observer.unobserve(el);
            });
        },
        { threshold: 0.4 }
    );

    countTargets.forEach((el) => countObserver.observe(el));
} else {
    countTargets.forEach((el) => {
        el.textContent = el.dataset.countTo + (el.dataset.countSuffix || '');
    });
}
