<?php
/**
 * Block template for HUB Results Reports.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="results-reports py-5">
	<div class="container">
		<?php
		if ( have_rows( 'entries' ) ) {
			// Collect all documents with their dates.
			$documents = array();
			while ( have_rows( 'entries' ) ) {
				the_row();
				$item_date         = get_sub_field( 'date' );
				$item_title        = get_sub_field( 'title' );
				$item_report_file  = get_sub_field( 'report_file' );
				$item_presentation = get_sub_field( 'presentation_file' );
				$item_webcast_link = get_sub_field( 'webcast' );

				// Handle both file array and file ID for report file.
				if ( is_numeric( $item_report_file ) ) {
					$item_report_file = acf_get_attachment( $item_report_file );
				}

				// Handle both file array and file ID for presentation file.
				if ( is_numeric( $item_presentation ) ) {
					$item_presentation = acf_get_attachment( $item_presentation );
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
						'date_obj'          => $date_obj,
						'formatted_date'    => $date_obj->format( 'd/m/Y' ),
						'year'              => $date_obj->format( 'Y' ),
						'title'             => $item_title,
						'report_file'       => $item_report_file,
						'presentation_file' => $item_presentation,
						'webcast_link'      => $item_webcast_link,
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
				<ul class="nav nav-tabs" id="resultsReportsTabs" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="current-tab" data-bs-toggle="tab" data-bs-target="#current" type="button" role="tab" aria-controls="current" aria-selected="true">
							<?= esc_html( $latest_year ); ?>
						</button>
					</li>
					<?php
					if ( $has_archive ) {
						?>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="archive-tab" data-bs-toggle="tab" data-bs-target="#archive" type="button" role="tab" aria-controls="archive" aria-selected="false">
							Archive
						</button>
					</li>
						<?php
					}
					?>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content" id="resultsReportsTabContent">
					<!-- Current Year Tab -->
					<div class="tab-pane fade show active" id="current" role="tabpanel" aria-labelledby="current-tab">
						<div class="results-reports__item results-reports__item--header">
							<div class="results-reports__meta">
								<span class="results-reports__date">Date</span>
								<span class="results-reports__title">Title</span>
							</div>
							<div class="results-reports__links">
								<span>Report</span>
								<span>Presentation</span>
								<span>Webcast</span>
							</div>
						</div>

						<?php
						foreach ( $current_year_docs as $doc ) {
							$report_file       = $doc['report_file'];
							$presentation_file = $doc['presentation_file'];
							$report_filesize   = isset( $report_file['filesize'] ) && $report_file['filesize'] ? format_bytes( $report_file['filesize'] ) : '';
							$presentation_size = isset( $presentation_file['filesize'] ) && $presentation_file['filesize'] ? format_bytes( $presentation_file['filesize'] ) : '';

							// Handle webcast link - could be array or string.
							$webcast_url = '';
							if ( is_array( $doc['webcast_link'] ) && isset( $doc['webcast_link']['url'] ) ) {
								$webcast_url = $doc['webcast_link']['url'];
							} elseif ( is_string( $doc['webcast_link'] ) ) {
								$webcast_url = $doc['webcast_link'];
							}
							?>
							<div class="results-reports__item">
								<div class="results-reports__meta">
									<span class="results-reports__date"><?= esc_html( $doc['formatted_date'] ); ?></span>
									<span class="results-reports__title"><?= esc_html( $doc['title'] ); ?></span>
								</div>
								<div class="results-reports__links">
									<?php if ( $report_file && isset( $report_file['url'] ) ) : ?>
									<a href="<?= esc_url( $report_file['url'] ); ?>" target="_blank" class="results-reports__link">
										<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/pdf-icon.svg' ); ?>" alt="PDF Icon" width="30" height="30" />
									</a>
									<?php endif; ?>
									<?php if ( $presentation_file && isset( $presentation_file['url'] ) ) : ?>
									<a href="<?= esc_url( $presentation_file['url'] ); ?>" target="_blank" class="results-reports__link">
										<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/pdf-icon.svg' ); ?>" alt="PDF Icon" width="30" height="30" />
									</a>
									<?php endif; ?>
									<?php if ( $webcast_url ) : ?>
									<a href="<?= esc_url( $webcast_url ); ?>" target="_blank" class="results-reports__link">
										<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/webcast-icon.svg' ); ?>" alt="Webcast Icon" width="30" height="30" />
									</a>
									<?php endif; ?>
								</div>
							</div>
							<?php
						}
						?>
					</div>

					<?php if ( $has_archive ) : ?>
					<!-- Archive Tab -->
					<div class="tab-pane fade" id="archive" role="tabpanel" aria-labelledby="archive-tab">
						<div class="results-reports__item results-reports__item--header">
							<div class="results-reports__meta">
								<span class="results-reports__date">Date</span>
								<span class="results-reports__title">Title</span>
							</div>
							<div class="results-reports__links">
								<span>Report</span>
								<span>Presentation</span>
								<span>Webcast</span>
							</div>
						</div>

						<?php
						foreach ( $archive_docs as $doc ) {
							$report_file       = $doc['report_file'];
							$presentation_file = $doc['presentation_file'];
							$report_filesize   = isset( $report_file['filesize'] ) && $report_file['filesize'] ? format_bytes( $report_file['filesize'] ) : '';
							$presentation_size = isset( $presentation_file['filesize'] ) && $presentation_file['filesize'] ? format_bytes( $presentation_file['filesize'] ) : '';

							// Handle webcast link - could be array or string.
							$webcast_url = '';
							if ( is_array( $doc['webcast_link'] ) && isset( $doc['webcast_link']['url'] ) ) {
								$webcast_url = $doc['webcast_link']['url'];
							} elseif ( is_string( $doc['webcast_link'] ) ) {
								$webcast_url = $doc['webcast_link'];
							}
							?>
							<div class="results-reports__item">
								<div class="results-reports__meta">
									<span class="results-reports__date"><?= esc_html( $doc['formatted_date'] ); ?></span>
									<span class="results-reports__title"><?= esc_html( $doc['title'] ); ?></span>
								</div>
								<div class="results-reports__links">
									<?php if ( $report_file && isset( $report_file['url'] ) ) : ?>
									<a href="<?= esc_url( $report_file['url'] ); ?>" target="_blank" class="results-reports__link">
										<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/pdf-icon.svg' ); ?>" alt="PDF Icon" width="30" height="30" />
									</a>
									<?php endif; ?>
									<?php if ( $presentation_file && isset( $presentation_file['url'] ) ) : ?>
									<a href="<?= esc_url( $presentation_file['url'] ); ?>" target="_blank" class="results-reports__link">
										<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/pdf-icon.svg' ); ?>" alt="PDF Icon" width="30" height="30" />
									</a>
									<?php endif; ?>
									<?php if ( $webcast_url ) : ?>
									<a href="<?= esc_url( $webcast_url ); ?>" target="_blank" class="results-reports__link">
										<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/webcast-icon.svg' ); ?>" alt="Webcast Icon" width="30" height="30" />
									</a>
									<?php endif; ?>
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
				echo '<p class="h3 has-sipco-coral-100-color">Coming late 2026</p>';
			}
		} else {
			echo '<p class="h3 has-sipco-coral-100-color">Coming late 2026</p>';
		}
		?>
	</div>
</section>