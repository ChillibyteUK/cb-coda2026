<?php
/**
 * Template for displaying the blog index page.
 *
 * @package cb-coda2026
 */

defined( 'ABSPATH' ) || exit;

$page_for_posts = get_option( 'page_for_posts' );

get_header();
?>
<main id="main">
	<?php
	// Display ACF blocks and content from the "page for posts".
	$knowledge_pushthrough_block = null;
	if ( $page_for_posts ) {
		// Get the page for posts object.
		$posts_page = get_post( $page_for_posts );

		if ( $posts_page && $posts_page->post_content ) {
			// Set up global $post for ACF and content functions.
			global $post;
			$original_post = $post;
			$post          = $posts_page; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			setup_postdata( $post );

			// Parse blocks to extract knowledge-pushthrough block.
			$blocks           = parse_blocks( $posts_page->post_content );
			$filtered_content = '';

			foreach ( $blocks as $block ) {
				$filtered_content .= render_block( $block );
			}

			// Output the filtered page content (excluding knowledge-pushthrough).
			echo wp_kses_post( $filtered_content );

			// Restore original post data.
			$post = $original_post; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
			wp_reset_postdata();
		}
	}



	?>
    <section class="latest_posts mt-5">
		<a id="latest-posts" class="anchor"></a>
        <div class="container pb-5">
            <?php
			// Check if there are any posts first.
			$args = array(
				'post_type'      => 'post',
				'post_status'    => array( 'publish' ),
				'posts_per_page' => 1, // Just check if at least one post exists.
			);
			$check_query = new WP_Query( $args );
			$has_posts = $check_query->have_posts();
			wp_reset_postdata();

			if ( ! $has_posts ) {
				// Display coming soon banner.
				?>
				<div class="row">
					<div class="col-12">
						<div class="coming-soon-banner py-5">
							<h2 class="has-sipco-coral-100-color">Coming soon</h2>
						</div>
					</div>
				</div>
				<?php
			} else {
				// Get all categories for filter buttons.
				$all_categories = get_categories(
					array(
						'hide_empty' => true,
						'orderby'    => 'name',
						'order'      => 'ASC',
					)
				);

				if ( ! empty( $all_categories ) ) {
					?>
					<div class="row mb-5 index-filters">
                    <div class="col-12 col-md-6 col-lg-3 mb-3 mb-lg-0">
                        <label for="category-filter" class="visually-hidden">Filter by category</label>
                        <select class="form-select filter-select" id="category-filter" data-filter-type="category" aria-label="Filter by category">
                            <option value="all" selected>All Categories</option>
                            <?php
							foreach ( $all_categories as $category ) {
								// Hide "Research PDF" - it's combined with "Research".
								if ( 'research' === $category->slug ) {
									continue;
								}
								// Map research-text to research in the dropdown.
								$display_slug = ( 'research-text' === $category->slug ) ? 'research' : $category->slug;
								?>
                                <option value="<?= esc_attr( $display_slug ); ?>"><?= esc_html( $category->name ); ?></option>
                            	<?php
							}
							?>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label for="year-filter" class="visually-hidden">Filter by year</label>
                        <select class="form-select filter-select" id="year-filter" data-filter-type="year" aria-label="Filter by year">
                            <option value="all" selected>All Years</option>
                            <?php
                            // Get all unique post years.
                            global $wpdb;
							// phpcs:ignore WordPress.DB.DirectDatabaseQuery
                            $years = $wpdb->get_col( "SELECT DISTINCT YEAR(post_date) FROM {$wpdb->posts} WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC" );
                            foreach ( $years as $yr ) {
                                ?>
                                <option value="<?= esc_attr( $yr ); ?>"><?= esc_html( $yr ); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
					<div class="col-12 col-lg-6 mb-3 mb-lg-0">
						<form role="search" method="get" class="d-flex gap-2 align-items-center" action="<?= esc_url( home_url( '/' ) ); ?>">
							<label for="search-input" class="visually-hidden">Search posts</label>
							<input type="search" class="form-control" id="search-input" name="s" placeholder="Search posts..." autocomplete="off" value="<?= esc_attr( get_search_query() ); ?>" aria-label="Search posts">
							<button type="submit" class="btn btn--mid-blue search-button">Search</button>
						</form>
					</div>
				</div>
				<?php
				}
				?>
				<div class="row g-5">
				<?php
				// Custom query to include published posts.
				$args = array(
					'post_type'      => 'post',
					'post_status'    => array( 'publish' ), // Include published posts.
					'orderby'        => 'date',
					'order'          => 'DESC', // Descending order.
					'posts_per_page' => -1,    // Get all posts.
				);

            $q = new WP_Query( $args );

            if ( $q->have_posts() ) {
				while ( $q->have_posts() ) {
					$q->the_post();
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
						// Map both research and research-text to research for filtering.
						$categories = str_replace( array( 'research-text', 'research' ), 'research', $categories );
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
					// Map research-text to research for switch statement.
					if ( 'research-text' === $catslug ) {
						$catslug = 'research';
					}

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
						case 'interview':
							$read_more = 'Watch now';
							break;
						case 'news':
							$read_more = 'Read now';
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
			} else {
				echo '<p>No posts found.</p>';
			}

			// Reset post data.
			wp_reset_postdata();
			?>
			</div>
			<?php
			} // End has_posts check.
			?>
        </div>
    </section>
	<?php
	// Display the knowledge-pushthrough block if it was found.
	if ( $knowledge_pushthrough_block ) {
		echo render_block( $knowledge_pushthrough_block ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
	?>
</main>
<?php
// Only include the filtering script if there are posts.
if ( $has_posts ) {
	?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterSelects = document.querySelectorAll('.filter-select');
    
    // Client-side filtering for category/year
    function filterPosts() {
        const posts = document.querySelectorAll('[data-category]');
        const categoryFilter = document.getElementById('category-filter').value;
        const yearFilter = document.getElementById('year-filter').value;
        
        posts.forEach(post => {
            const postCategories = post.getAttribute('data-category');
            const postYear = post.getAttribute('data-year');
            
            const categoryMatch = categoryFilter === 'all' || (postCategories && postCategories.includes(categoryFilter));
            const yearMatch = yearFilter === 'all' || postYear === yearFilter;
            
            if (categoryMatch && yearMatch) {
                post.style.display = 'block';
            } else {
                post.style.display = 'none';
            }
        });
    }

    // Filter on change
    filterSelects.forEach(select => {
        select.addEventListener('change', filterPosts);
    });
});
</script>
	<?php
}
?>

<?php

get_footer();
?>