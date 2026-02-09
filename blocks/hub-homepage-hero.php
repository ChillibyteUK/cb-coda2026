<?php
/**
 * Block template for HUB Homepage Hero.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="homepage-hero">
	<div class="homepage-hero__background">
		<?= wp_get_attachment_image( get_field( 'background' ), 'full', false, array( 'alt' => '' ) ); ?>
	</div>
	<div class="homepage-hero__overlay" aria-hidden="true"></div>
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-7">
				<div class="has-h-3-font-size">SIMCo Infrastructure Private Credit OFC</div>
				<h1 class="mb-5"><?= wp_kses_post( get_field( 'title' ) ); ?></h1>
			</div>
		</div>
	</div>
</div>
