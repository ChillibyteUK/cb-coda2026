<?php
/**
 * Block template for CB Feature List.
 *
 * @package cb-coda2026
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="feature-list id-container py-5">
	<div class="mx-4 mx-md-5 has-lime-1000-border-top py-3">
		<div class="row g-5">
			<div class="col-md-6">
				<h2 class="has-lime-1100-color"><?= esc_html( get_field( 'title' ) ); ?></h2>
			</div>
			<div class="col-md-6">
				<ul class="lined-list">
					<?= wp_kses_post( cb_list( get_field( 'features' ) ) ); ?>
				</ul>	
			</div>
		</div>
	</div>
</section>