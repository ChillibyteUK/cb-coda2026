<?php
/**
 * Block template for CB What we delivered.
 *
 * @package cb-coda2026
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="delivered">
	<div class="delivered__container pb-5">
		<div class="delivered__header">
			<div class="id-container pt-1 px-4 px-md-5">
				<h2>WHAT WE DELIVERED</h2>
			</div>
		</div>
        <div class="delivered__grid-wrapper">
			<?php
			$delay = 0;
			while ( have_rows( 'deliverables' ) ) {
				the_row();
				$item = get_sub_field( 'item' );
				?>
				<div class="delivered__item">
					<div class="id-container px-4 px-md-5"  data-aos="fade-up" data-aos-delay="<?= esc_attr( $delay ); ?>">
						<?= esc_html( $item ); ?>
					</div>
				</div>
				<?php
				$delay += 100;
			}
			?>
		</div>
	</div>
</section>