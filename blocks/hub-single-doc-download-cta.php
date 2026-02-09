<?php
/**
 * Block template for HUB Single Doc Download CTA.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

$policy_file = get_field( 'policy_file' );

?>
<section class="single-doc-cta">
	<div class="single-doc-cta__background">
		<?= wp_get_attachment_image( get_field( 'background' ), 'full', false, array( 'alt' => '' ) ); ?>
	</div>
	<div class="single-doc-cta__overlay" aria-hidden="true"></div>

	<div class="container py-5">
		<div class="row align-items-center">
			<div class="col-md-5">
                <h2><?= esc_html( get_field( 'cta_title' ) ); ?></h2>
                <p><?= wp_kses_post( get_field( 'cta_intro' ) ); ?></p>
				<div>
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/pdf-icon--wo.svg' ); ?>" width="50" height="64" alt="PDF Icon" class="me-2 mb-1" />
					<a href="<?= esc_url( $policy_file['url'] ); ?>" target="_blank" class="btn btn-dark btn-arrow">Download now</a>
				</div>
			</div>
		</div>
	</div>
</section>
