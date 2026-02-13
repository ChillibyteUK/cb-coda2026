<?php
/**
 * Block template for CB Gradient Intro.
 *
 * @package cb-coda2026
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="gradient-intro grad-main py-5">
	<div class="id-container px-4 px-md-5">
		<div class="row">
			<div class="col-md-8">
				<div class="fs-500 fw-regular"><?= wp_kses_post( get_field( 'content' ) ); ?></div>
			</div>
		</div>
	</div>
</section>