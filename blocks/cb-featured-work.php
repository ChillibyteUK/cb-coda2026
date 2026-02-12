<?php
/**
 * Block template for CB Featured Work.
 *
 * @package cb-coda2026
 */

defined( 'ABSPATH' ) || exit;

// Block ID.
$block_id = $block['id'] ?? '';

$count             = get_field( 'count' ) ?? 4;
$selected_services = get_field( 'services' ) ?? array();

$query_args = array(
	'post_type'      => 'case_study',
	'posts_per_page' => $count,
	'orderby'        => 'date',
	'order'          => 'DESC',
);

// If services are selected, filter by those term IDs.
if ( ! empty( $selected_services ) && is_array( $selected_services ) ) {
	$query_args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
		array(
			'taxonomy' => 'service',
			'field'    => 'term_id',
			'terms'    => $selected_services,
		),
	);
}

$q = new WP_Query( $query_args );
if ( $q->have_posts() ) {
	?>
<section id="<?php echo esc_attr( $block_id ); ?>" class="cb-featured-work">
	<div class="cb-featured-work__pre-title">
		<div class="id-container py-4 px-4 px-md-5">
			FEATURED WORK
		</div>
	</div>
	<div class="id-container pb-2">
		<div class="row g-2">
		<?php
		while ( $q->have_posts() ) {
			$q->the_post();
			$video     = get_field( 'vimeo_url', get_the_ID() );
			$has_video = $video ? 'has_video' : '';
			?>
			<div class="col-md-6">
				<a href="<?= esc_url( get_the_permalink() ); ?>" class="cb-featured-work__card <?= esc_attr( $has_video ); ?>">
				<?php
				$video = get_field( 'vimeo_url', get_the_ID() );
				if ( $video ) {
					?>
					<iframe class="work-video" src="<?= esc_url( cb_vimeo_url_with_dnt( $video ) ); ?>&background=1&autoplay=0" frameborder="0" allow="fullscreen" allowfullscreen></iframe>
						<?php
				}
				?>
				<?= get_work_image( get_the_ID(), 'cb-featured-work__image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div class="cb-featured-work__content px-4 px-md-5">
						<div class="cb-featured-work__title">
						<?php the_title(); ?> <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/img/arrow-bk.svg' ); ?>" width=23 height=21 alt="" class="cb-featured-work__arrow" />
						</div>
						<div class="cb-featured-work__desc">
						<?php
						// get the case_study_subtitle field from the cb-case-study-hero block if available.
						if ( ! function_exists( 'cb_find_hero_subtitle' ) ) {
							/**
							 * Recursively searches blocks for the case study hero subtitle.
							 *
							 * @param array $blocks The array of blocks to search through.
							 * @return string The case study subtitle if found, empty string otherwise.
							 */
							function cb_find_hero_subtitle( $blocks ) {
								foreach ( $blocks as $block ) {
									if (
										isset( $block['blockName'] ) &&
										'cb/cb-case-study-hero' === $block['blockName'] &&
										! empty( $block['attrs']['data']['case_study_subtitle'] )
									) {
										return $block['attrs']['data']['case_study_subtitle'];
									}
									if ( ! empty( $block['innerBlocks'] ) ) {
										$found = cb_find_hero_subtitle( $block['innerBlocks'] );
										if ( $found ) {
											return $found;
										}
									}
								}
								return '';
							}
						}
						$post_blocks = parse_blocks( get_the_content( null, false, get_the_ID() ) );
						$subtitle    = cb_find_hero_subtitle( $post_blocks );
						if ( $subtitle ) {
							echo esc_html( $subtitle );
						} else {
							echo wp_kses_post( wp_trim_words( get_the_excerpt(), 18, '...' ) );
						}
						?>
						</div>
					</div>
				</a>
			</div>
					<?php
		}
		?>
		</div>
	</div>
</section>
	<?php

	wp_reset_postdata();
}


add_action(
	'wp_footer',
	function () {
		?>
<script>
document.addEventListener('DOMContentLoaded', function() {
	document.querySelectorAll('.cb-featured-work__card').forEach(function(card) {
		const iframe = card.querySelector('iframe.work-video');
		if (!iframe) return;

		card.addEventListener('mouseenter', function() {
			iframe.contentWindow?.postMessage({ method: 'play' }, '*');
		});
		card.addEventListener('mouseleave', function() {
			iframe.contentWindow?.postMessage({ method: 'pause' }, '*');
			iframe.contentWindow?.postMessage({ method: 'setCurrentTime', value: 0 }, '*');
		});
		card.addEventListener('focusin', function() {
			iframe.contentWindow?.postMessage({ method: 'play' }, '*');
		});
		card.addEventListener('focusout', function() {
			iframe.contentWindow?.postMessage({ method: 'pause' }, '*');
			iframe.contentWindow?.postMessage({ method: 'setCurrentTime', value: 0 }, '*');
		});
	});
});
</script>
		<?php
	}
);
