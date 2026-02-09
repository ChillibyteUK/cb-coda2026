<?php
/**
 * Block template for HUB Contact.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="contact">
	<div class="container py-5">
		<div class="row g-4">
			<div class="col-md-6 pt-2">
				<a href="<?= esc_url( get_field( 'map_embed_code', 'option' ) ); ?>" target="_blank" rel="noopener noreferrer">
				<?php
				$map_image_id = get_field( 'map_image', 'option' );
				if ( $map_image_id ) {
					echo wp_get_attachment_image( $map_image_id, 'full', false, array( 'class' => 'img-fluid mb-4', 'alt' => 'SIPCo map' ) );
				}
				?>
				</a>
				<div class="mt-4">
					<div class="mb-2"><strong>SIPCo Infrastructure Private Credit OFC</strong></div>
					<?= do_shortcode( '[contact_address]' ); ?>
					<div class="mt-2"><?= esc_html( get_field( 'contact_phone', 'option' ) ); ?></div>
				</div>
			</div>
			<div class="col-md-6">
				<?= do_shortcode( get_field( 'shortcode' ) ); ?>
			</div>
		</div>
	</div>
</section>