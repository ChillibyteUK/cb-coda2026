<?php
/**
 * Block template for HUB Provider Cards.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="provider-cards">
	<div class="container py-5">
		<div class="row g-5">
			<?php
			while ( have_rows( 'cards' ) ) {
				the_row();
				?>
				<div class="col-12 col-lg-4">
					<div class="provider-cards__card text-center">
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
									'class' => 'provider-cards__card-image',
									'alt'   => esc_attr( get_sub_field( 'title' ) ),
								)
							);
							?>
							<?php
						}
						?>
						<div class="provider-cards__card-body text-center px-4">
							<h3 class="h4"><?php the_sub_field( 'title' ); ?></h3>
							<?php the_sub_field( 'content' ); ?>
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>