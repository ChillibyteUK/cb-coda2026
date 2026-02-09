<?php
/**
 * Block template for HUB Page Hero.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

$size = 'short' === get_field( 'size' ) ? 'page-hero--short' : '';
?>
<section class="page-hero <?= esc_attr( $size ); ?>">
	<div class="page-hero__background">
		<?= wp_get_attachment_image( get_field( 'background' ), 'full', false, array( 'alt' => '' ) ); ?>
	</div>
	<div class="page-hero__overlay" aria-hidden="true"></div>
	<div class="container h-100 d-flex">
		<div class="row my-auto w-100">
			<div class="row">
				<div class="col-12 col-md-6 d-flex flex-column justify-content-center">
					<h1 class="page-hero__title mb-5"><?= wp_kses_post( get_field( 'title' ) ); ?></h1>
					<div class="page-hero__content"><?= wp_kses_post( get_field( 'content' ) ); ?></div>
				</div>
			</div>
		</div>
	</div>
</section>