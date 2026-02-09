<?php
/**
 * Block template for HUB 4 Col Image Cards.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="four-col-image-cards">
	<div class="container py-4">
		<div class="row g-5">
			<?php
			while ( have_rows( 'cards' ) ) {
				the_row();
				?>
				<div class="col-12 col-md-4">
					<div class="four-col-image-cards__card">
						<?php
						$image = get_sub_field( 'image' );
						if ( $image ) {
							echo wp_get_attachment_image(
								$image,
								'full',
								false,
								array(
									'class' => 'four-col-image-cards__card-image',
									'alt'   => esc_attr( get_sub_field( 'title' ) ),
								)
							);
						}
						?>
						<div class="four-col-image-cards__card-body">
							<div class="fs-h4-body-bold fw-bold mb-3"><?php the_sub_field( 'title' ); ?></div>
							<div><?php the_sub_field( 'content' ); ?></div>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>