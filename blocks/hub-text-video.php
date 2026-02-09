<?php
/**
 * Block template for HUB Text Video.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

$level = get_field( 'level' ) ? get_field( 'level' ) : 'h2';

$split = get_field( 'split' );

$left  = 'col-lg-5';
$right = 'col-lg-7';

switch ( $split ) {
	case '40-60':
		$left  = 'col-lg-5';
		$right = 'col-lg-7';
		break;
	case '50-50':
		$left  = 'col-lg-6';
		$right = 'col-lg-6';
		break;
	case '60-40':
		$left  = 'col-lg-7';
		$right = 'col-lg-5';
		break;
	default:
		$left  = 'col-lg-5';
		$right = 'col-lg-7';
		break;
}

$align = 'Top' === get_field( 'content_alignment' ) ? '' : 'my-xl-auto';

$watermark = get_field( 'has_watermark' );
$water     = ! empty( $watermark ) && 'Yes' === $watermark[0] ? 'block-watermark' : '';

?>
<section class="text-video <?= esc_attr( $water ); ?>">
	<div class="container py-5">
		<?php
		if ( get_field( 'title' ) ) {
			?>
		<<?= esc_html( $level ); ?> class="<?= esc_html( $level ); ?> mb-5" data-aos="fade-right"><?= wp_kses_post( get_field( 'title' ) ); ?></<?= esc_html( $level ); ?>>
			<?php
		}
		?>
		<div class="row g-5">
			<div class="<?= esc_attr( $left ); ?> <?= esc_attr( $align ); ?>">
				<div data-aos="fade-right">
					<?= wp_kses_post( get_field( 'content' ) ); ?>
				</div>
				<?php
				$button_link = get_field( 'cta' );
				$link_url    = $button_link ? $button_link['url'] : '';
				if ( $link_url ) {
					$target = $button_link['target'] ? $button_link['target'] : '_self';
					?>
					<a href="<?= esc_url( $link_url ); ?>" target="<?= esc_attr( $target ); ?>" class="btn btn--sipco-coral btn-arrow mt-3"><?= esc_html( $button_link['title'] ); ?></a>
					<?php
				}
				?>
			</div>
			<div class="<?= esc_attr( $right ); ?>">
				<div class="ratio ratio-16x9">
					<?php
					$vimeo_id    = get_field( 'vimeo_id' );
					$block_title = get_field( 'title' );

					// Try to get title from Vimeo API if video is publicly embeddable.
					$video_title = get_vimeo_data_from_id( $vimeo_id, 'title' );

					// Fallback hierarchy: Vimeo title -> Block title -> Generic description.
					if ( ! empty( $video_title ) ) {
						$iframe_title = $video_title;
					} elseif ( ! empty( $block_title ) ) {
						$iframe_title = wp_strip_all_tags( $block_title );
					} else {
						$iframe_title = 'Video player';
					}
					?>
					<iframe src="https://player.vimeo.com/video/<?= esc_attr( $vimeo_id ); ?>" title="<?= esc_attr( $iframe_title ); ?>" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
</section>