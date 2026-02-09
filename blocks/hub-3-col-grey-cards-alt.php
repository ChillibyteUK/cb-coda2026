<?php
/**
 * Block template for HUB 3 Col Grey Cards Alt.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="three-col-grey-cards-alt">
	<div class="container py-4">
		<div class="row g-3">
			<?php
			while ( have_rows( 'cards' ) ) {
				the_row();
				?>
				<div class="col-12 col-md-4">
					<div class="three-col-grey-cards-alt__card">
						<div class="three-col-grey-cards-alt__card-body">
							<div class="fs-body mb-3"><?php the_sub_field( 'title' ); ?></div>
							<div class="h3"><?php the_sub_field( 'content' ); ?></div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>