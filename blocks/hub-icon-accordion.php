<?php
/**
 * Block template for HUB Icon Accordion.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

// Generate unique ID for this accordion instance.
$accordion_id = 'accordion-' . uniqid();

?>
<section class="icon-accordion-block ppy-5">
	<div class="container" data-aos="fade-up">
		<?php
		$items = get_field( 'sections' ) ?? array();

		if ( ! empty( $items ) ) {
			?>
		<div class="accordion" id="<?= esc_attr( $accordion_id ); ?>">
			<?php
			foreach ( $items as $i => $it ) {
				// $collapsed = ( 0 === $i ) ? '' : 'collapsed';
				// $show      = ( 0 === $i ) ? 'show' : '';
				// $expanded  = ( 0 === $i ) ? 'true' : 'false';
				$collapsed = 'collapsed';
				$show      = '';
				$expanded  = 'false';
				?>
			<div class="accordion-item" data-aos="fade-up" data-aos-delay="<?= esc_attr( 100 * ( $i + 1 ) ); ?>">
				<h2 class="accordion-header" id="heading-<?= esc_attr( $accordion_id . '-' . $i ); ?>">
					<button class="accordion-button <?= esc_attr( $collapsed ); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= esc_attr( $accordion_id . '-' . $i ); ?>" aria-expanded="<?= esc_attr( $expanded ); ?>" aria-controls="collapse-<?= esc_attr( $accordion_id . '-' . $i ); ?>">
						<?= wp_get_attachment_image( $it['icon'] ?? '' ); ?>
						<?= esc_html( $it['title'] ?? '' ); ?>
					</button>
				</h2>
				<div id="collapse-<?= esc_attr( $accordion_id . '-' . $i ); ?>" class="accordion-collapse collapse <?= esc_attr( $show ); ?>" aria-labelledby="heading-<?= esc_attr( $accordion_id . '-' . $i ); ?>" data-bs-parent="#<?= esc_attr( $accordion_id ); ?>">
					<div class="accordion-body">
						<div class="accordion-body__inner">
							<?= wp_kses_post( $it['content'] ?? '' ); ?>
						</div>
					</div>
				</div>
			</div>
				<?php
			}
			?>
		</div>
			<?php
		}
		?>
	</div>
</section>