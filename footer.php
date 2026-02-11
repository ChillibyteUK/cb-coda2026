<?php
/**
 * Footer template for the Identity Coda 2026 theme.
 *
 * This file contains the footer section of the theme, including navigation menus,
 * office addresses, and colophon information.
 *
 * @package cb-coda2026
 */

defined( 'ABSPATH' ) || exit;
?>
<div id="footer-top"></div>

<footer class="footer pt-5 pb-4">
    <div class="id-container px-4 px-md-5">
        <div class="row pb-4 g-4">
			<!-- 1. Social icons -->
			<div class="col-12 col-md-6 col-lg-4 order-9 order-md-1">
				<!-- <div class="footer-title--lg mb-3">Connect. Share. Follow.</div> -->
				<?= do_shortcode( '[social_icons class="fa-2x"]' ); ?>
			</div>
			<!-- 2. Services -->
			<div class="col-12 col-sm-6 col-md-4 col-lg-2 order-2 order-md-3 order-lg-2">
				<div class="footer-title mb-4"><a href="/services/">Services</a></div>
				<?=
				wp_nav_menu(
					array(
						'theme_location' => 'footer_menu_services',
						'menu_class'     => 'footer__menu',
					)
				);
				?>
			</div>
			<!-- 3. About -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-2 order-4 order-md-4 order-lg-3">
				<div class="footer-title mb-4"><a href="/about/">About</a></div>
				<?=
				wp_nav_menu(
					array(
						'theme_location' => 'footer_menu_about',
						'menu_class'     => 'footer__menu',
					)
				);
				?>
			</div>
			<!-- 4. Our Brands -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-2 order-6 order-md-7 order-lg-4">
				<div class="footer-title mb-4"><a href="/about/#brands">Identity Brands</a></div>
				<?=
				wp_nav_menu(
					array(
						'theme_location' => 'footer_menu_identity',
						'menu_class'     => 'footer__menu',
					)
				);
				?>
			</div>
			<!-- 5. Legau -->
            <div class="col-12 col-sm-6 col-md-4 col-lg-2 order-6 order-md-7 order-lg-4">
				<div class="footer-title mb-4">Legal &amp; info</div>
				<?=
				wp_nav_menu(
					array(
						'theme_location' => 'footer_menu_legal',
						'menu_class'     => 'footer__menu',
					)
				);
				?>
			</div>
			<!-- ROW 2 -->
			<!-- 6. Email -->
			<div class="col-12 col-md-4 order-8 order-md-2 order-lg-6">
				<strong>
				<div class="mb-5">Let's talk.</div>
				<?= do_shortcode( '[contact_email]' ); ?>
				</strong>
			</div>
			<!-- 7. Work -->
			<div class="col-12 col-sm-6 col-md-4 col-lg-2 order-1 order-md-5 order-lg-7">
				<div class="footer-title mb-5"><a href="/work/">Work</a></div>
            </div>
			<!-- 8. News -->
			<div class="col-12 col-sm-6 col-md-4 col-lg-2 order-3 order-md-6 order-lg-8">
				<div class="footer-title mb-4"><a href="/news/">News</a></div>
			</div>
		</div>
	</div>
	<div class="footer__logo">
		<div class="id-container py-5 px-4 px-md-5">
			<div id="footer-logo-clip" class="footer__logo-clip">
				<div id="footer-logo-inner" class="footer__logo-inner">
					<!-- Inline logo SVG (long form) so we can animate precisely -->
<svg id="Layer_2" data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 985 97.47">
  <defs>
    <style>
      .cls-9 {
        fill: #fff;
      }

      .cls-2 {
        fill: #478f00;
      }
    </style>
  </defs>
  <g id="Layer_1-2" data-name="Layer 1">
    <path class="cls-2" d="M822.36,57.58c-.01,17.11,14.3,31.13,32.05,31.05,18.04-.07,32.1-13.8,32.18-31.12.08-17.31-14.2-31.01-32.19-30.98-17.78.03-32.02,13.83-32.04,31.04M886.5,31.87c.03-.56.09-1.12.09-1.69,0-8.18-.01-16.36.02-24.54.01-3.65,2.3-5.74,6.03-5.63,1.82.05,2.9,1.06,3,2.84.02.34,0,.69,0,1.03,0,17.83,0,35.66,0,53.49s-11.64,33.09-29.01,38.28c-18.36,5.48-37.69-1.94-47.29-17.35-6.21-9.97-7.88-20.68-4.38-31.79,4.7-14.97,15.23-24.4,30.98-27.86,10.41-2.28,20.45-.63,29.68,4.75,3.48,2.03,6.64,4.47,9.31,7.47.35.4.64.86.96,1.29.2-.1.39-.19.59-.3"/>
    <path class="cls-2" d="M943.73,26.55c-17.69-.05-32.12,13.78-32.23,30.89-.11,17.03,14.32,31.23,32.12,31.19,17.92-.03,32.1-13.6,32.18-31.08.08-17.2-14.33-30.95-32.07-31M975.33,83c-.49.55-.96,1.12-1.47,1.64-11.21,11.09-24.69,15.31-40.26,11.42-16.51-4.12-26.7-14.73-30.24-30.78-3.8-17.18,4.9-34.59,20.92-42.85,8.11-4.18,16.77-5.53,25.88-4.16,10.31,1.55,18.75,6.34,25.37,14.03,6.06,7.04,9.22,15.31,9.37,24.44.2,12.39.05,24.78.05,37.16,0,2.41-1.28,3.59-3.78,3.56-3.06-.03-5.18-1.96-5.27-4.92-.08-2.59-.03-5.19-.05-7.78,0-.52-.05-1.04-.08-1.56-.15-.07-.3-.14-.45-.2"/>
    <path class="cls-2" d="M797.49,57.61c-.06-17.27-14.35-31.07-32.18-31.06-17.82,0-32.09,13.84-32.1,31.12,0,17.01,14.47,30.96,32.16,31,17.56.03,32.18-14.1,32.12-31.06M765.29,17.73c22.64.06,40.91,17.51,41.19,39.33.28,21.84-17.52,40.05-40.59,40.34-23.15.29-41.26-17.36-41.72-38.95-.48-22.51,17.79-40.44,41.12-40.72"/>
    <path class="cls-2" d="M692.06,17.76c11.59.14,21.38,4.29,29.47,12.27,1.44,1.41,1.47,2.43.11,3.94-2.07,2.28-5.47,2.41-8.24.57-3.03-2.02-6.02-4.27-9.37-5.61-9.48-3.81-18.94-3.27-27.91,1.64-8.26,4.53-13.62,11.39-15.58,20.39-2.48,11.37.7,21.32,9.45,29.28,11.5,10.47,28.62,11.21,41.26,2.1.98-.7,1.85-1.53,2.82-2.24,2.45-1.79,5.76-1.36,7.59.94,1.14,1.44,1.11,2.96-.21,4.24-7.11,6.92-15.63,11.03-25.71,11.94-11.7,1.06-22.07-2.2-30.89-9.6-8.26-6.92-13.03-15.78-14-26.37-1.15-12.52,3.03-23.3,12.2-32.09,7.98-7.65,17.78-11.39,29.03-11.4"/>
    <polygon class="cls-9" points="303.2 19.01 303.2 73.24 244.11 19.01 228.94 19.01 228.94 96.88 246.08 96.88 246.08 42.99 305.17 96.88 320.34 96.88 320.34 19.01 303.2 19.01"/>
    <path class="cls-9" d="M571.57,19c9.9,12.45,29.27,38.59,29.27,38.59l28.92-38.59h20.53l-41.06,52.32v25.55h-17.14v-25.21l-41.42-52.67h20.89Z"/>
    <polygon class="cls-9" points="458.3 19.01 458.3 33.26 493.29 33.26 493.29 96.88 510.43 96.88 510.43 33.26 545.43 33.26 545.43 19.01 458.3 19.01"/>
    <polygon class="cls-9" points="331.57 19.01 331.57 33.26 366.56 33.26 366.56 96.88 383.7 96.88 383.7 33.26 418.7 33.26 418.7 19.01 331.57 19.01"/>
    <rect class="cls-9" y="19.01" width="17.5" height="77.87"/>
    <polygon class="cls-9" points="148.06 19 133.44 19 133.44 96.88 148.06 96.88 213.59 96.88 213.59 82.62 148.06 82.62 148.06 65.07 213.59 65.07 213.59 50.81 148.06 50.81 148.06 33.26 213.59 33.26 213.59 19 148.06 19"/>
    <path class="cls-9" d="M53.48,33.32h24.02c8.64,0,15.2,1.99,19.52,5.9,4.46,4.04,6.72,10.32,6.72,18.67,0,16.6-8.59,24.67-26.24,24.67h-24.02v-49.24ZM110.15,29.18c-7.28-6.75-17.9-10.18-31.55-10.18h-42.13v77.87h42.13c27.35,0,42.42-13.85,42.42-38.99,0-12.36-3.66-22.02-10.87-28.71"/>
    <rect class="cls-9" x="429.93" y="19.01" width="17.14" height="77.87"/>
  </g>
</svg>				</div>
			</div>
		</div>
	</div>
	<div class="id-container px-4 px-md-5 pt-4 footer__colophon">
		Identity Events Management Ltd, Registered Number - 04217845 | VAT Number - GB 813 0913 60
	</div>
</footer>
<script>
(function(){
    const clip = document.getElementById('footer-logo-clip');
    const inner = document.getElementById('footer-logo-inner');
    const svg = document.getElementById('footer-logo-svg');
    if (!clip || !inner || !svg) return;

    const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let triggered = false;

    function prepareAndAnimate() {
        clip.style.width = '100%';
        inner.style.transformOrigin = 'left center';
        inner.style.width = '200%';
        inner.style.display = 'block';
        inner.style.transform = 'translateX(0)';
        if (prefersReduced) {
            inner.style.transform = 'translateX(-50%)';
            return;
        }
        const animDuration = 1.6;
        const gsapEase = 'power3.out';
        if (window.gsap && typeof window.gsap.to === 'function') {
            window.gsap.to(inner, { xPercent: -50, duration: animDuration, ease: gsapEase });
        } else {
            inner.style.transition = 'transform ' + animDuration + 's cubic-bezier(.22,.9,.32,1)';
            requestAnimationFrame(() => { inner.style.transform = 'translateX(-50%)'; });
        }
    }

    function triggerIfVisible(el) {
        const rect = el.getBoundingClientRect();
        const vh = window.innerHeight || document.documentElement.clientHeight;
        return rect.top < vh && rect.bottom > 0;
    }

    const triggerEl = document.querySelector('.footer__colophon') || document.querySelector('.footer__logo') || clip;

    if (triggerEl) {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (triggered) return;
                if (entry.isIntersecting && entry.intersectionRatio > 0) {
                    triggered = true;
                    prepareAndAnimate();
                    obs.disconnect();
                }
            });
        }, { rootMargin: '0px 0px -10px 0px', threshold: [0.1] });

        observer.observe(triggerEl);

        // Immediately check if already visible (e.g., on fast loads or short pages)
        if (triggerIfVisible(triggerEl)) {
            triggered = true;
            prepareAndAnimate();
            observer.disconnect();
        }
    }

    let resizeTimer = null;
    window.addEventListener('resize', () => {
        if (triggered) return;
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            clip.style.width = '100%';
            inner.style.width = '200%';
        }, 120);
    });
})();
</script>

<?php wp_footer(); ?>
</body>

</html>