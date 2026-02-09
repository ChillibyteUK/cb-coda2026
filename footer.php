<?php
/**
 * Footer template for the SIMCo 2025 theme.
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
    <div class="container">
		<h2 class="h3 mb-4">SIMCo Infrastructure Private Credit OFC</h2>
        <div class="row pb-4 g-4">
			<div class="col-sm-4">
				<div class="mb-2">
					<?= do_shortcode( '[contact_address]' ); ?>
				</div>
				<div class="mb-3">
					<?= esc_html( get_field( 'contact_phone', 'option' ) ); ?>
				</div>
				<?= do_shortcode( '[social_icons class="fa-2x"]' ); ?>
			</div>
			<div class="col-sm-3">
				<nav aria-label="Footer menu 1">
				<?=
				wp_nav_menu(
					array(
						'theme_location' => 'footer_menu1',
						'menu_class'     => 'footer__menu',
					)
				);
				?>
				</nav>
            </div>
            <div class="col-sm-5">
				<div>Managed by SIMCAP:</div>
				<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/simcap-logo.svg' ); ?>" alt="SIMCAP Logo" width="279" height="58" class="my-2" />
				<div>Advised by SIMCo:</div>
				<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/simco-logo.svg' ); ?>" alt="SIMCo Logo" width="279" height="58" class="my-2" />
				<div class="mt-3">
					&copy; <?= esc_html( gmdate( 'Y' ) ); ?> Sequoia Investment Management Company Limited
				</div>
			</div>
		</div>
	</div>
</footer>
<script>
// Remove loading class once DOM and Bootstrap are ready
document.addEventListener('DOMContentLoaded', function() {
    document.documentElement.classList.remove('loading');
});
</script>
<?php wp_footer(); ?>
</body>

</html>