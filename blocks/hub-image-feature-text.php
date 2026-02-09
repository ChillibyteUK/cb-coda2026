<?php
/**
 * Block template for HUB Image Feature Text.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

if ( $block['anchor'] ) {
	$anchor_id = sanitize_title( $block['anchor'] );
	?>
<a id="<?= esc_attr( $anchor_id ); ?>" class="anchor"></a>
	<?php
}

// Support Gutenberg color picker.
$bg_slug = ! empty( $block['backgroundColor'] ) ? $block['backgroundColor'] : '';
$fg_slug = ! empty( $block['textColor'] ) ? $block['textColor'] : '';

$inline_styles = '';
if ( $bg_slug ) {
	$inline_styles .= '--_bg: var(--col-' . $bg_slug . '); ';
}
if ( $fg_slug ) {
	$inline_styles .= '--_fg: var(--col-' . $fg_slug . '); ';
}

?>
<section class="image-feature-text" id="<?= esc_attr( $anchor_id ); ?>" <?= $inline_styles ? 'style="' . esc_attr( $inline_styles ) . '"' : ''; ?>>
	<div class="image-feature-text__background">
		<?= wp_get_attachment_image( get_field( 'background' ), 'full', false, array( 'alt' => '' ) ); ?>
	</div>
	<div class="image-feature-text__overlay" aria-hidden="true"></div>

	<div class="container py-5">
		<div class="row align-items-center">
			<div class="col-md-5">
				<h2 class="mb-4"><?= esc_html( get_field( 'title' ) ); ?></h2>
				<div class="has-h-4-font-size"><?= wp_kses_post( get_field( 'content' ) ); ?></div>
			</div>
		</div>
	</div>
</section>