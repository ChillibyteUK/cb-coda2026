<?php
/**
 * Block template for HUB Full Width.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

// Support Gutenberg color picker.
$bg         = ! empty( $block['backgroundColor'] ) ? 'has-' . $block['backgroundColor'] . '-background-color py-5' : '';
$fg         = ! empty( $block['textColor'] ) ? 'has-' . $block['textColor'] . '-color' : '';
$section_id = $block['anchor'] ?? null;

// Get Gutenberg classes.
$classes = isset( $block['className'] ) ? $block['className'] : '';
if ( empty( $classes ) ) {
	$classes = '';
}

?>
<section id="<?= esc_attr( $section_id ); ?>" class="full-width <?= esc_attr( $bg . ' ' . $fg . ' ' . $classes ); ?>">
    <div class="container" data-aos="fade-up">
		<?php
		if ( get_field( 'title' ) ) {
			?>
			<h2 class="h2 mb-4"><?= esc_html( get_field( 'title' ) ); ?></h2>
			<?php
		}
		?>
        <?= wp_kses_post( get_field( 'content' ) ); ?>
    </div>
</section>