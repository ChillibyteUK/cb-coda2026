<?php
/**
 * Block template for HUB Icon Bar.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="icon-bar has-sipco-red-background-color has-white-color py-5">
	<div class="container">
		<div class="row g-5 justify-content-center">
			<div class="col-md-4 text-center fw-bold">
				<?= wp_get_attachment_image( get_field( 'icon_1' ), 'full', false, array( 'class' => 'd-block mx-auto mb-3' ) ); ?>
				<div class="w-constrained-xs mx-auto"><?= esc_html( get_field( 'text_1' ) ); ?></div>
			</div>
			<div class="col-md-4 text-center fw-bold">
				<?= wp_get_attachment_image( get_field( 'icon_2' ), 'full', false, array( 'class' => 'd-block mx-auto mb-3' ) ); ?>
				<div class="w-constrained-xs mx-auto"><?= esc_html( get_field( 'text_2' ) ); ?></div>
			</div>
			<div class="col-md-4 text-center fw-bold">
				<?= wp_get_attachment_image( get_field( 'icon_3' ), 'full', false, array( 'class' => 'd-block mx-auto mb-3' ) ); ?>
				<div class="w-constrained-xs mx-auto"><?= esc_html( get_field( 'text_3' ) ); ?></div>
			</div>
		</div>
	</div>
</section>