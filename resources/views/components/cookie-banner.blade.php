@props(['settings'])

{{--
    Bandeau RGPD : les scripts de mesure d'audience (GA4/GTM) ne sont injectés
    qu'après un clic explicite sur "Accepter" — jamais avant, et jamais par
    défaut — conformément aux recommandations CNIL sur le consentement préalable.
--}}
<div
    x-data="cookieConsent()"
    x-show="!decided"
    x-cloak
    x-transition
    class="fixed inset-x-0 bottom-0 z-50 border-t border-stone/30 bg-white/98 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] backdrop-blur"
    role="region"
    aria-label="Gestion des cookies"
>
    <div class="mx-auto flex max-w-5xl flex-col gap-4 px-4 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <p class="text-sm text-navy">{{ $settings->cookie_banner_text }}</p>
        <div class="flex shrink-0 gap-3">
            <button type="button" @click="decline()" class="btn-outline">Refuser</button>
            <button type="button" @click="accept()" class="btn-primary">Accepter</button>
        </div>
    </div>
</div>

@once
    <script>
        function cookieConsent() {
            return {
                decided: false,
                init() {
                    try {
                        this.decided = ['accepted', 'declined'].includes(localStorage.getItem('cookie_consent'));
                        if (localStorage.getItem('cookie_consent') === 'accepted') {
                            this.loadAnalytics();
                        }
                    } catch (e) {
                        this.decided = true;
                    }

                    // Permet de rouvrir le bandeau depuis le lien "Gérer mes cookies" du footer,
                    // sans recharger la page (exigence CNIL : retrait aussi simple que le dépôt).
                    window.addEventListener('reopen-cookie-banner', () => {
                        try { localStorage.removeItem('cookie_consent'); } catch (e) {}
                        this.decided = false;
                    });
                },
                accept() {
                    try { localStorage.setItem('cookie_consent', 'accepted'); } catch (e) {}
                    this.decided = true;
                    this.loadAnalytics();
                },
                decline() {
                    try { localStorage.setItem('cookie_consent', 'declined'); } catch (e) {}
                    this.decided = true;
                },
                loadAnalytics() {
                    @if(!empty($settings->gtm_id))
                        if (!window.__gtmLoaded) {
                            window.__gtmLoaded = true;
                            window.dataLayer = window.dataLayer || [];
                            window.dataLayer.push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
                            const s = document.createElement('script');
                            s.async = true;
                            s.src = 'https://www.googletagmanager.com/gtm.js?id={{ $settings->gtm_id }}';
                            document.head.appendChild(s);
                        }
                    @endif
                    @if(!empty($settings->ga4_id))
                        if (!window.__ga4Loaded) {
                            window.__ga4Loaded = true;
                            const s = document.createElement('script');
                            s.async = true;
                            s.src = 'https://www.googletagmanager.com/gtag/js?id={{ $settings->ga4_id }}';
                            document.head.appendChild(s);
                            window.dataLayer = window.dataLayer || [];
                            window.gtag = function(){ window.dataLayer.push(arguments); };
                            window.gtag('js', new Date());
                            window.gtag('config', '{{ $settings->ga4_id }}');
                        }
                    @endif
                },
            };
        }
    </script>
@endonce
