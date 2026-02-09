<?php
/**
 * Block template for HUB Fund Documents.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="fund-documents py-5">
	<div class="container">
		<div class="accordion" id="fundDocumentsAccordion">
		<?php
		$index = 0;
		while ( have_rows( 'fund_documents' ) ) {
			the_row();
			$accordion_id = 'accordion-' . $index;
			$is_first     = ( 0 === $index );
			?>
			<div class="accordion-item">
				<h2 class="accordion-header" id="heading-<?= esc_attr( $accordion_id ); ?>">
					<button class="fs-h3-page-subtitle accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= esc_attr( $accordion_id ); ?>" aria-expanded="false" aria-controls="<?= esc_attr( $accordion_id ); ?>">
						<?= esc_html( get_sub_field( 'section_title' ) ); ?>
					</button>
				</h2>
				<div id="<?= esc_attr( $accordion_id ); ?>" class="accordion-collapse collapse" aria-labelledby="heading-<?= esc_attr( $accordion_id ); ?>" data-bs-parent="#fundDocumentsAccordion">
					<div class="accordion-body">
						<div class="fund-documents__documents">
						<?php
						while ( have_rows( 'documents' ) ) {
							the_row();
							$file = get_sub_field( 'file' );
							?>
							<a href="<?= esc_url( $file['url'] ); ?>" class="fund-documents__link" target="_blank">
								<?= esc_html( get_sub_field( 'document_title' ) ); ?>
								<span class="fund-documents__link-icon">
									<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/pdf-icon.svg' ); ?>" alt="PDF Icon" width="30" height="30" />
									<?= esc_html( format_bytes( $file['filesize'] ) ); ?>
								</span>
							</a>
							<?php
						}
						?>
						</div>
					</div>
				</div>
			</div>
			<?php
			++$index;
		}
		?>
		</div>
	</div>
</section>