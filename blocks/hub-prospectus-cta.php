<?php
/**
 * Block template for HUB Prospectus CTA.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

$prospectus_file = get_field( 'prospectus_file' );
$key_facts_file  = get_field( 'key_facts_file' );

?>
<section class="prospectus-cta block-watermark--light py-5">
    <div class="prospectus-cta__overlay"></div>
    <div class="container">
		<div class="row g-5">
			<div class="col-sm-4 col-lg-3">
				<?= wp_get_attachment_image( get_field( 'prospectus_cover' ), 'full', false, array( 'class' => 'prospectus-cta__cover' ) ); ?>
			</div>
			<div class="col-sm-8 col-lg-9">
				<h2 class="h3">Prospectus download</h2>
				<p style="max-width:50ch" class="mb-4">Click below to access the SIPCo Prospectus for detailed information on our offering.</p>
				<div>
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/pdf-icon.svg' ); ?>" width="50" height="64" alt="PDF Icon" class="me-2 mb-1" />
					<a href="<?= esc_url( $prospectus_file['url'] ); ?>" target="_blank" class="btn btn-dark btn-arrow">Download now</a>
				</div>
				<hr class="my-5">
				<h2 class="h3 mb-4">Key facts statement</h2>
				<div>
					<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/pdf-icon.svg' ); ?>" width="50" height="64" alt="PDF Icon" class="me-2 mb-1" />
					<a href="<?= esc_url( $key_facts_file['url'] ); ?>" target="_blank" class="btn btn-dark btn-arrow">Download now</a>
				</div>
			</div>
		</div>
    </div>
</section>