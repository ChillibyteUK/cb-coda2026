<?php
/**
 * Block template for CB Full Case Study.
 *
 * @package cb-coda2026
 */

defined( 'ABSPATH' ) || exit;

// Block ID.
$block_id = $block['id'] ?? '';

$bg_case_study = get_field( 'case_study' )[0] ?? null;

if ( ! $bg_case_study ) {
	$latest_query = new WP_Query(
		array(
			'post_type'      => 'case_study',
			'posts_per_page' => 1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		)
	);
	if ( $latest_query->have_posts() ) {
		$latest_query->the_post();
		$bg_case_study = get_the_ID();
		wp_reset_postdata();
	}
}

$is_front = is_front_page();

?>
<section class="work-index-hero">
	<div class="id-container">
		<?php
			// get title and thumbnail of first sticky or latest case study for background image.

		if ( $bg_case_study ) {
			?>
		<a href="<?= esc_url( get_the_permalink( $bg_case_study ) ); ?>" class="work-index-hero__background">
			<?php
			$bg_image_id = get_post_thumbnail_id( $bg_case_study );
			if ( $bg_image_id ) {
				echo wp_get_attachment_image( $bg_image_id, 'full', false, array( 'class' => 'work-index-hero__image' ) );
			}
		}
		if ( ! $is_front ) {
			?>
			<div class="overlay"></div>
			<div class="bottom-overlay"></div>
			<?php
		}


		$fw = $is_front ? 'fw-light' : 'fw-semi';
		?>
			<div class="work-index-hero__content px-4 px-md-5">
				<div class="work-index-hero__card-title has-700-font-size <?php echo esc_attr( $fw ); ?>">
					<?php echo esc_html( get_the_title( $bg_case_study ) ); ?> <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/img/arrow-wh.svg' ); ?>" width=23 height=21 alt="" class="cb-services-nav__item-icon" />
				</div>
				<div class="work-index-hero__card-desc">
					<?php
					// get the case_study_subtitle field from the cb-case-study-hero block if available.
					if ( ! function_exists( 'cb_find_hero_subtitle' ) ) {
						/**
						 * Find hero subtitle in parsed blocks.
						 *
						 * @param array $blocks Array of parsed block data.
						 * @return string The subtitle text or empty string.
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
					$post_blocks = parse_blocks( get_post_field( 'post_content', $bg_case_study ) );
					$subtitle    = cb_find_hero_subtitle( $post_blocks );
					if ( $subtitle ) {
						echo esc_html( $subtitle );
					} else {
						$excerpt = get_the_excerpt( $bg_case_study );
						echo wp_kses_post( wp_trim_words( $excerpt, 18, '...' ) );
					}
					?>
				</div>
			</div>
		<?php
		if ( $bg_case_study ) {
			?>
		</a>
			<?php
		}
		?>
	</div>
</section>