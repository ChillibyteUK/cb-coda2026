<?php
/**
 * Template for displaying single posts.
 *
 * @package cb-coda2026
 */

defined( 'ABSPATH' ) || exit;
get_header();

// get categories.
$categories     = get_the_category();
$first_category = null;
if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
	// get space separated list of category slugs.
	$first_category = $categories[0];
}
?>
<main id="main" class="single">
<section class="graphic-hero graphic-hero--short">
	<div class="container d-flex h-100">
		<div class="row w-100 align-items-end mb-4">
			<div class="col-md-6">
				<div class="graphic-hero__title h1">Insights</div>
			</div>
		</div>
	</div>
</section>
<div class="container">
	<div class="py-4">
		<a class="left-arrow" href="/insights/#latest-posts">Back to Insights</a>
	</div>
	<div class="row g-5">
		<div class="col-md-3">
			<div class="category-title"><?= esc_html( $first_category->name ); ?></div>
		</div>
		<div class="col-md-9">
			<h1 class="h2 mb-5"><?= esc_html( get_the_title() ); ?></h1>
			<div class="mb-4"><?= get_the_date( 'j/m/Y' ); ?></div>
			<?php
			if ( $first_category && (
				'podcast' === $first_category->slug ||
				'video' === $first_category->slug ||
				'interview' === $first_category->slug
				) ) {
				$video = get_field( 'video_link' );
				if ( $video ) {
					?>
			<div class="ratio ratio-16x9 mb-4">
				<iframe src="<?= esc_attr( $video ); ?>" title="<?= esc_attr( get_the_title() ); ?>" allowfullscreen></iframe>	
			</div>
					<?php
				}
			}

			if ( $first_category && 'news' === $first_category->slug ) {
				echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'class' => 'img-fluid mb-4' ) );
			}

			echo apply_filters( 'the_content', get_the_content() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			?>
			<?php
			// Custom navigation - exclude research category.
			// Get current post date for comparison.
			$current_post_date = get_the_date( 'Y-m-d H:i:s' );

			// Get previous post (older, published before current).
			$prev_post  = null;
			$prev_args  = array(
				'post_type'      => 'post',
				'posts_per_page' => 1,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
				'date_query'     => array(
					array(
						'before'    => $current_post_date,
						'inclusive' => false,
					),
				),
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					array(
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => 'research',
						'operator' => 'NOT IN',
					),
				),
			);
			$prev_query = new WP_Query( $prev_args );
			if ( $prev_query->have_posts() ) {
				$prev_post = $prev_query->posts[0];
			}
			wp_reset_postdata();

			// Get next post (newer, published after current).
			$next_post  = null;
			$next_args  = array(
				'post_type'      => 'post',
				'posts_per_page' => 1,
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'ASC',
				'date_query'     => array(
					array(
						'after'     => $current_post_date,
						'inclusive' => false,
					),
				),
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					array(
						'taxonomy' => 'category',
						'field'    => 'slug',
						'terms'    => 'research',
						'operator' => 'NOT IN',
					),
				),
			);
			$next_query = new WP_Query( $next_args );
			if ( $next_query->have_posts() ) {
				$next_post = $next_query->posts[0];
			}
			wp_reset_postdata();
			if ( $prev_post || $next_post ) {
				?>
			<nav class="navigation post-navigation" aria-label="Posts">
				<div class="nav-links">
					<?php if ( $prev_post ) : ?>
						<div class="nav-previous">
							<a class="btn btn-prev" href="<?= esc_url( get_permalink( $prev_post->ID ) ); ?>" rel="prev">
								Previous
							</a>
						</div>
					<?php endif; ?>
					<?php if ( $next_post ) : ?>
						<div class="nav-next">
							<a class="btn btn-next" href="<?= esc_url( get_permalink( $next_post->ID ) ); ?>" rel="next">
								Next
							</a>
						</div>
					<?php endif; ?>
				</div>
			</nav>
				<?php
			}
			?>
		</div>
	</div>
		<?php
		// Related posts - exclude current post and research category.
		$related_args = array(
			'post_type'      => 'post',
			'posts_per_page' => 3,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'post__not_in'   => array( get_the_ID() ),
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy' => 'category',
					'field'    => 'slug',
					'terms'    => 'research',
					'operator' => 'NOT IN',
				),
			),
		);

		$related_query = new WP_Query( $related_args );

		if ( $related_query->have_posts() ) {
			?>
		<div class="related-posts pt-5 pb-5">
			<h2 class="has-h-3-font-size mb-4">More Insights</h2>
			<div class="row g-5">
				<?php
				while ( $related_query->have_posts() ) {
					$related_query->the_post();
					// get categories.
					$categories = get_the_category();
					if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
						// get space separated list of category slugs.
						$first_category = $categories[0];
						// If there are multiple categories, use the first one.
						if ( count( $categories ) > 1 ) {
							// Get the first category slug.
							$categories = array_slice( $categories, 0, 1 );
						}
						// Convert to space separated list.
						$categories = implode( ' ', wp_list_pluck( $categories, 'slug' ) );
					}

					$plink  = get_permalink();
					$target = '_self';
					if ( 'research' === $first_category->slug ) {
						$plink  = wp_get_attachment_url( get_field( 'pdf', get_the_ID() ) );
						$target = '_blank';
					}
					if ( 'video' === $first_category->slug || 'podcast' === $first_category->slug ) {
						$video_link = get_field( 'video_link', get_the_ID() );
						if ( $video_link && ! ( str_contains( $video_link, 'youtube.com' ) || str_contains( $video_link, 'vimeo.com' ) ) ) {
							$plink  = $video_link;
							$target = '_blank';
						}
					}

                    // strip ' PDF' from research category name.
                    $catname = $first_category->name;
                    $catname = str_replace( ' PDF', '', $catname );

					$catslug = $first_category->slug;

					switch ( $catslug ) {
						case 'research':
							$read_more = 'Read now';
							break;
						case 'video':
							$read_more = 'Watch now';
							break;
						case 'podcast':
							$read_more = 'Play now';
							break;
						default:
							$read_more = 'Read now';
							break;
					}

					?>
					<div class="col-md-6 col-lg-4" data-category="<?= esc_attr( $categories ); ?>" data-year="<?= esc_attr( get_the_date( 'Y' ) ); ?>">
						<a href="<?= esc_url( $plink ); ?>" target="<?= esc_attr( $target ); ?>" class="latest-insights__item">
							<div class="latest-insights__img-wrapper">
								<?php
								$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
								if ( $thumbnail_id ) {
									echo wp_get_attachment_image(
										$thumbnail_id,
										'large',
										false,
										array(
											'class' => 'img-fluid',
											'alt'   => '',
										)
									);
								}
								?>
							</div>
							<div class="category"><?= esc_html( $catname ); ?></div>
							<h3><?= esc_html( get_the_title() ); ?></h3>
							<div class="read-more <?= esc_attr( $catslug ); ?>" aria-label="<?= esc_attr( $read_more . ' about ' . get_the_title() ); ?>"><?= esc_html( $read_more ); ?></div>
						</a>
					</div>
					<?php
				}
				wp_reset_postdata();
				?>
			</div>
		</div>
			<?php
		}
		?>
</main>
<?php
get_footer();
?>