<?php
/**
 * Block template for HUB 3 Col Image Cards.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="three-col-image-cards">
	<div class="container py-5">
		<?php
		if ( get_field( 'title' ) ) {
			?>
		<h2 class="mb-4"><?php the_field( 'title' ); ?></h2>
			<?php
		}
		?>
		<div class="row g-5">
			<?php
			while ( have_rows( 'cards' ) ) {
				the_row();
				?>
				<div class="col-12 col-lg-4">
					<div class="three-col-image-cards__card">
						<?php
						$image = get_sub_field( 'image' );
						if ( $image ) {
							?>
							<?php
							echo wp_get_attachment_image(
								$image,
								'full',
								false,
								array(
									'class' => 'three-col-image-cards__card-image',
									'alt'   => esc_attr( get_sub_field( 'title' ) ),
								)
							);
							?>
							<?php
						}
						?>
						<div class="three-col-image-cards__card-body">
							<?php the_sub_field( 'title' ); ?>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>