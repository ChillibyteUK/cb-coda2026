<?php
/**
 * Block template for CB Dept Email.
 *
 * @package cb-coda2026
 */

defined( 'ABSPATH' ) || exit;

$bg         = ! empty( $block['backgroundColor'] ) ? 'has-' . $block['backgroundColor'] . '-background-color' : '';
$fg         = ! empty( $block['textColor'] ) ? 'has-' . $block['textColor'] . '-color' : '';
$section_id = $block['anchor'] ?? $block['id'];

?>
<section id="<?= esc_attr( $section_id ); ?>" class="dept-email py-5 <?php echo esc_attr( $bg . ' ' . $fg ); ?>">
	<div class="id-container px-4 px-md-5">
		<?php
		$first = true;
		while ( have_rows( 'departments' ) ) {
			the_row();
			$border = $first ? '' : 'has-lime-1000-border-top';
			?>
		<div class="row g-5 <?= esc_attr( $border ); ?> mt-3 pb-5 mb-4">
			<div class="col-md-7 mt-2 has-600-font-size fw-light"><?= esc_html( get_sub_field( 'department' ) ); ?></div>
			<div class="col-md-5 mt-2 lh-normal has-400-font-size fw-regular">
				<?php
				$emails = get_sub_field( 'email' );
				echo cb_list_to_email( $emails ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</div>
		</div>
			<?php
			$first = false;
		}
		?>
	</div>
</section>
