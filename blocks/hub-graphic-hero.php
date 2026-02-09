<?php
/**
 * Block template for HUB Graphic Hero.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

$height = get_field( 'height' );

$h     = 'Short' === $height ? 'graphic-hero--short' : 'graphic-hero--full';
$align = 'Short' === $height ? 'align-items-end mb-4' : 'align-items-center';

?>
<section class="graphic-hero <?= esc_attr( $h ); ?>">
	<div class="container d-flex h-100">
		<div class="row w-100 <?= esc_attr( $align ); ?>">
			<div class="col-md-6">
				<h1 class="graphic-hero__title"><?= wp_kses_post( get_field( 'title' ) ); ?></h1>
			</div>
		</div>
	</div>
</section>