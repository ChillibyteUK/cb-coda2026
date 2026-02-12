<?php
/**
 * Template Name: Text Page
 *
 * @package cb-coda2026
 */

defined( 'ABSPATH' ) || exit;
get_header();

?>
<main id="main" class="text-page">
	<section class="has-lime-1000-border-top has-lime-1000-border-bottom has-lime-900-text">
		<div class="id-container px-4 px-md-5">
			<h2 class="fs-300 fw-regular lh-tightest pt-4 pb-3 mb-0 text-uppercase" ><?= wp_kses_post( get_the_title() ); ?></h2>
		</div>
	</section>
	<div class="id-container">
		<div class="row post-content-row mb-5">
			<div class="col-md-3"></div>
			<div class="col-md-9 post-content px-4 px-md-5 ps-md-0 pe-md-5">
				<?php
				echo apply_filters( 'the_content', get_the_content() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</div>
		</div>
	</div>
</main>
<?php
get_footer();
?>