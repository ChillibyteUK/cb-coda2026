<?php
/**
 * Block template for CB Leadership.
 *
 * @package cb-coda2026
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="leadership has-neutral-300-background-color">
	<div class="id-container px-4 px-md-5">
		<div class="w-constrained py-5 fw-regular fs-500" style="--width:60ch;"><?= wp_kses_post( get_field( 'intro' ) ); ?></div>
		<div class="row g-5">
			<?php
			while ( have_rows( 'team' ) ) {
				the_row();
				$name  = get_sub_field( 'name' );
				$lrole = get_sub_field( 'role' );
				$bio   = get_sub_field( 'bio' );
				?>
			<div class="col-md-4">
				<div class="leadership__item">
					<div class="leadership__image">
						<?= wp_get_attachment_image( get_sub_field( 'image' ), 'large' ); ?>
					</div>
					<div class="leadership__name">
						<?= esc_html( $name ); ?>
					</div>
					<div class="leadership__role">
						<?= esc_html( $lrole ); ?>
					</div>
					<div class="leadership__bio">
						<?= wp_kses_post( $bio ); ?>
					</div>
				</div>
			</div>
				<?php
			}
			?>
		</div>
	</div>
</section>