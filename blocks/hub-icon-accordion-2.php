<?php
/**
 * Block template for HUB Icon Accordion 2.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

// Generate unique ID for this accordion instance.
$accordion_id = 'accordion-' . uniqid();

?>
<section class="hub-icon-accordion-2 py-5">
	<div class="container" data-aos="fade-up">
		<div class="row align-items-center">
			<div class="col-md-1">
				<?php
				if ( get_field( 'icon' ) ) {
					echo wp_get_attachment_image(
						get_field( 'icon' ) ?? '',
						'full',
						false,
						array(
							'class' => 'hub-icon-accordion-2__icon',
							'alt'   => esc_attr( get_field( 'title' ) . ' Icon' ),
						)
					);
				}
				?>
			</div>
			<div class="col-md-11">
				<?php
				if ( get_field( 'title' ) ) {
					?>
				<h2 class="has-h-3-font-size"><?= esc_html( get_field( 'title' ) ); ?></h2>
					<?php
				}
				?>
			</div>
		</div>
		<?php
		if ( get_field( 'intro' ) ) {
			?>
		<div class="row">
			<div class="col-md-11 offset-md-1 mb-4"><?= wp_kses_post( get_field( 'intro' ) ); ?></div>
		</div>
			<?php
		}
		?>
		<div class="row">
			<div class="col-md-11 offset-md-1">
				<?php
				$items = get_field( 'items' ) ?? array();

				if ( ! empty( $items ) ) {
					?>
				<div class="accordion" id="<?= esc_attr( $accordion_id ); ?>">
					<?php
					$c = 0;
					foreach ( $items as $i => $it ) {
						// $collapsed = ( 0 === $i ) ? '' : 'collapsed';
						// $show      = ( 0 === $i ) ? 'show' : '';
						// $expanded  = ( 0 === $i ) ? 'true' : 'false';
						$collapsed = 'collapsed';
						$show      = '';
						$expanded  = 'false';
						++$c;
						?>
					<div class="accordion-item mb-3" data-aos="fade-up" data-aos-delay="<?= esc_attr( 100 * ( $i + 1 ) ); ?>">
						<h3 class="accordion-header" id="heading-<?= esc_attr( $accordion_id . '-' . $i ); ?>">
							<button class="accordion-button has-body-medium-font-size <?= esc_attr( $collapsed ); ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= esc_attr( $accordion_id . '-' . $i ); ?>" aria-expanded="<?= esc_attr( $expanded ); ?>" aria-controls="collapse-<?= esc_attr( $accordion_id . '-' . $i ); ?>">
								<?= esc_html( $c ); ?>. <?= esc_html( $it['title'] ?? '' ); ?>
							</button>
						</h3>
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
		</div>
	</div>
</section>