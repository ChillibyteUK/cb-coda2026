<?php
/**
 * Block template for HUB Mailing List CTA.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="mailing-list-cta">
	<div class="mailing-list-cta__background">
		<?= wp_get_attachment_image( get_field( 'image' ), 'full', false, array( 'alt' => '' ) ); ?>
	</div>
	<div class="mailing-list-cta__overlay" aria-hidden="true"></div>
	<div class="container py-5">
		<div class="row">
			<div class="col-md-5">
				<h3><?= esc_html( get_field( 'title' ) ); ?></h3>
				<?= do_shortcode( get_field( 'shortcode' ) ); ?>
			</div>
		</div>
	</div>
</section>

