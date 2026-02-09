<?php
/**
 * Block template for HUB Team.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

$team = get_field( 'team' );

$cards = get_field( 'cards' ) ? get_field( 'cards' ) : 'three-cards';

?>
<section class="hub-team mb-4">
	<div class="container">
		<h2 class="mb-4 hub-team__heading"><?= esc_html( $team->name ); ?></h2>
	</div>
	<div class="container hub-team__grid <?= esc_attr( $cards ); ?>">
		<?php
		$q = new WP_Query(
			array(
				'post_type'      => 'person',
				'posts_per_page' => -1,
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					array(
						'taxonomy' => 'team',
						'field'    => 'id',
						'terms'    => $team->term_id,
					),
				),
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
			)
		);

		while ( $q->have_posts() ) {
			$q->the_post();
			$person_id   = get_the_ID();
			$dept_terms  = get_the_terms( $person_id, 'department' );
			$dept_slugs  = $dept_terms && ! is_wp_error( $dept_terms ) ? implode( ' ', wp_list_pluck( $dept_terms, 'slug' ) ) : '';
			$person_name = mb_strtolower( get_the_title( $person_id ) );
			?>
			<button class="hub-team__card" data-aos="fade" type="button" aria-expanded="false" aria-controls="team-detail-<?= esc_attr( $person_id ); ?>" data-person-id="<?= esc_attr( $person_id ); ?>" data-dept="<?= esc_attr( $dept_slugs ); ?>" data-name="<?= esc_attr( $person_name ); ?>">
				<div class="hub-team__image-wrapper">
					<?=
					get_the_post_thumbnail(
						$person_id,
						'large',
						array(
							'class' => 'hub-team__image',
							'alt'   => esc_attr( get_the_title( $person_id ) ),
						)
					);
					?>
				</div>
				<div class="px-4 py-2 hub-team__name-holder">
					<div class="hub-team__name pb-2 fw-bold has-h-5-font-size"><?= esc_html( get_the_title( $person_id ) ); ?></div>
					<div class="hub-team__title"><?= wp_kses_post( get_field( 'title', $person_id ) ); ?></div>
				</div>
			</button>
			<div class="detail-content" id="team-detail-<?= esc_attr( $person_id ); ?>" role="region" aria-label="<?= esc_attr( get_the_title( $person_id ) . ' details' ); ?>" hidden>
				<div class="row">
					<div class="col-md-8 offset-md-2">
						<?= wp_kses_post( get_the_content() ); ?>
					</div>
				</div>
			</div>
			<?php
		}
		wp_reset_postdata();
		?>
	</div>
</section>
<?php
