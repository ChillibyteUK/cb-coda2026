<?php
/**
 * Block template for HUB Factsheets.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="factsheets py-5">
	<div class="container">
		<?php
		if ( have_rows( 'entries' ) ) {
			// Collect all documents with their dates.
			$documents = array();
			while ( have_rows( 'entries' ) ) {
				the_row();
				$item_date  = get_sub_field( 'date' );
				$item_title = get_sub_field( 'title' );
				$item_file  = get_sub_field( 'file' );

				// Handle both file array and file ID.
				if ( is_numeric( $item_file ) ) {
					$item_file = acf_get_attachment( $item_file );
				}

				// Try multiple date formats.
				$date_obj = DateTime::createFromFormat( 'Ymd', $item_date );
				if ( ! $date_obj ) {
					$date_obj = DateTime::createFromFormat( 'Y-m-d', $item_date );
				}
				if ( ! $date_obj ) {
					$date_obj = DateTime::createFromFormat( 'd/m/Y', $item_date );
				}

				if ( $date_obj ) {
					$documents[] = array(
						'date_obj'       => $date_obj,
						'formatted_date' => $date_obj->format( 'd/m/Y' ),
						'year'           => $date_obj->format( 'Y' ),
						'title'          => $item_title,
						'file'           => $item_file,
					);
				}
			}

			if ( ! empty( $documents ) ) {
				// Sort documents by date descending.
				usort(
					$documents,
					function ( $a, $b ) {
						return $b['date_obj'] <=> $a['date_obj'];
					}
				);

				// Get the latest year.
				$latest_year = $documents[0]['year'];

				// Split into current year and archive.
				$current_year_docs = array();
				$archive_docs      = array();

				foreach ( $documents as $doc ) {
					if ( $doc['year'] === $latest_year ) {
						$current_year_docs[] = $doc;
					} else {
						$archive_docs[] = $doc;
					}
				}

				$has_archive = ! empty( $archive_docs );
				?>

				<!-- Nav tabs -->
				<ul class="nav nav-tabs" id="factsheetsTabs" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="factsheets-current-tab" data-bs-toggle="tab" data-bs-target="#factsheets-current" type="button" role="tab" aria-controls="factsheets-current" aria-selected="true">
							<?= esc_html( $latest_year ); ?>
						</button>
					</li>
					<?php if ( $has_archive ) : ?>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="factsheets-archive-tab" data-bs-toggle="tab" data-bs-target="#factsheets-archive" type="button" role="tab" aria-controls="factsheets-archive" aria-selected="false">
							Archive
						</button>
					</li>
					<?php endif; ?>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content" id="factsheetsTabContent">
					<!-- Current Year Tab -->
					<div class="tab-pane fade show active" id="factsheets-current" role="tabpanel" aria-labelledby="factsheets-current-tab">
						<?php
						foreach ( $current_year_docs as $doc ) {
							$file     = $doc['file'];
							$filesize = isset( $file['filesize'] ) && $file['filesize'] ? format_bytes( $file['filesize'] ) : '';
							?>
							<div class="factsheets__item">
								<div class="factsheets__meta">
									<span class="factsheets__date"><?= esc_html( $doc['formatted_date'] ); ?></span>
									<span class="factsheets__title"><?= esc_html( $doc['title'] ); ?></span>
								</div>
								<div class="factsheets__links">
									<?php
									if ( $file && isset( $file['url'] ) ) {
										?>
									<a href="<?= esc_url( $file['url'] ); ?>" target="_blank" class="factsheets__link">
										<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/pdf-icon.svg' ); ?>" alt="PDF Icon" width="30" height="30" />
										<?php if ( $filesize ) : ?>
										<span class="factsheets__filesize"><?= esc_html( $filesize ); ?></span>
										<?php endif; ?>
									</a>
										<?php
									}
									?>
								</div>
							</div>
							<?php
						}
						?>
					</div>

					<?php if ( $has_archive ) : ?>
					<!-- Archive Tab -->
					<div class="tab-pane fade" id="factsheets-archive" role="tabpanel" aria-labelledby="factsheets-archive-tab">
						<?php
						foreach ( $archive_docs as $doc ) {
							$file     = $doc['file'];
							$filesize = isset( $file['filesize'] ) && $file['filesize'] ? format_bytes( $file['filesize'] ) : '';
							?>
							<div class="factsheets__item">
								<div class="factsheets__meta">
									<span class="factsheets__date"><?= esc_html( $doc['formatted_date'] ); ?></span>
									<span class="factsheets__title"><?= esc_html( $doc['title'] ); ?></span>
								</div>
								<div class="factsheets__links">
									<?php
									if ( $file && isset( $file['url'] ) ) {
										?>
									<a href="<?= esc_url( $file['url'] ); ?>" target="_blank" class="factsheets__link">
										<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/pdf-icon.svg' ); ?>" alt="PDF Icon" width="30" height="30" />
										<?php
										if ( $filesize ) {
											?>
										<span class="factsheets__filesize"><?= esc_html( $filesize ); ?></span>
											<?php
										}
										?>
									</a>
										<?php
									}
									?>
								</div>
							</div>
							<?php
						}
						?>
					</div>
					<?php endif; ?>
				</div>
				<?php
			} else {
				echo '<p class="h3 has-sipco-coral-100-color">First monthly factsheet coming early 2026</p>';
			}
		} else {
			echo '<p class="h3 has-sipco-coral-100-color">First monthly factsheet coming early 2026</p>';
		}
		?>
	</div>
</section>