<?php
/**
 * Block template for CB Locations.
 *
 * @package cb-coda2026
 */

defined( 'ABSPATH' ) || exit;

$bg         = ! empty( $block['backgroundColor'] ) ? 'has-' . $block['backgroundColor'] . '-background-color' : '';
$fg         = ! empty( $block['textColor'] ) ? 'has-' . $block['textColor'] . '-color' : '';
$section_id = $block['anchor'] ?? $block['id'];

?>
<section id="<?= esc_attr( $section_id ); ?>" class="locations py-5 <?php echo esc_attr( $bg . ' ' . $fg ); ?>">
	<div class="id-container px-4 px-md-5">
		<?php
		$first = true;
		while ( have_rows( 'locations' ) ) {
			the_row();
			$weight = $first ? 'fw-regular' : 'fw-light';
			?>
		<div class="row g-5 has-lime-1000-border-top mt-3 pb-5 mb-4">
			<div class="col-md-7 has-800-font-size">
				<?= esc_html( get_sub_field( 'location' ) ); ?>
			</div>
			<div class="col-md-5 lh-normal has-400-font-size <?= esc_attr( $weight ); ?>">
				<?= wp_kses_post( get_sub_field( 'address' ) ); ?>
			</div>
		</div>
			<?php
			$first = false;
		}
		?>
	</div>
</section>