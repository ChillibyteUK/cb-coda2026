<?php
/**
 * Block template for HUB Circulars & Announcements.
 *
 * @package hub-sipco2026
 */

defined( 'ABSPATH' ) || exit;

?>
<section class="circulars-announcements py-5">
	<div class="container">
		<?php
		$tab_list = array(
			'news_files'       => 'News releases',
			'regulatory_files' => 'Regulatory notices',
			'circulars_files'  => 'Circulars',
		);
		?>
		
		<!-- Nav tabs -->
		<ul class="nav nav-tabs" id="circularsAnnouncementsTabs" role="tablist">
			<?php
			$index = 0;
			foreach ( $tab_list as $tab_key => $tab_label ) {
				$active_class  = ( 0 === $index ) ? 'active' : '';
				$aria_selected = ( 0 === $index ) ? 'true' : 'false';
				?>
				<li class="nav-item" role="presentation">
					<button class="nav-link <?= esc_attr( $active_class ); ?>" id="<?= esc_attr( $tab_key ); ?>-tab" data-bs-toggle="tab" data-bs-target="#<?= esc_attr( $tab_key ); ?>" type="button" role="tab" aria-controls="<?= esc_attr( $tab_key ); ?>" aria-selected="<?= esc_attr( $aria_selected ); ?>">
						<?= esc_html( $tab_label ); ?>
					</button>
				</li>
				<?php
				++$index;
			}
			?>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content" id="circularsAnnouncementsTabContent">
			<?php
			$index = 0;
			foreach ( $tab_list as $tab_key => $tab_label ) {
				$active_class = ( 0 === $index ) ? 'show active' : '';
				?>
				<div class="tab-pane fade <?= esc_attr( $active_class ); ?>" id="<?= esc_attr( $tab_key ); ?>" role="tabpanel" aria-labelledby="<?= esc_attr( $tab_key ); ?>-tab">
					<?php
					if ( have_rows( $tab_key ) ) {
						// Collect all documents with their dates.
						$documents = array();
						while ( have_rows( $tab_key ) ) {
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

							// Group by year and output.
							$grouped_by_year = array();
							foreach ( $documents as $doc ) {
								$grouped_by_year[ $doc['year'] ][] = $doc;
							}

							// Output each year group in accordions.
							$year_index = 0;
							?>
							<div class="accordion" id="accordion-<?= esc_attr( $tab_key ); ?>">
							<?php
							foreach ( $grouped_by_year as $doc_year => $year_docs ) {
								$accordion_id = $tab_key . '-year-' . $doc_year;
								$is_first     = ( 0 === $year_index );
								?>
								<div class="accordion-item">
									<h3 class="accordion-header" id="heading-<?= esc_attr( $accordion_id ); ?>">
										<button class="accordion-button<?= $is_first ? '' : ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= esc_attr( $accordion_id ); ?>" aria-expanded="<?= $is_first ? 'true' : 'false'; ?>" aria-controls="<?= esc_attr( $accordion_id ); ?>">
											<?= esc_html( $doc_year ); ?>
										</button>
									</h3>
									<div id="<?= esc_attr( $accordion_id ); ?>" class="accordion-collapse collapse<?= $is_first ? ' show' : ''; ?>" aria-labelledby="heading-<?= esc_attr( $accordion_id ); ?>" data-bs-parent="#accordion-<?= esc_attr( $tab_key ); ?>">
										<div class="accordion-body">
											<?php
											foreach ( $year_docs as $doc ) {
												$file     = $doc['file'];
												$filesize = isset( $file['filesize'] ) && $file['filesize'] ? format_bytes( $file['filesize'] ) : '';
												?>
												<a href="<?= esc_url( $doc['file']['url'] ); ?>" target="_blank" class="circulars-announcements__link">
													<span class="circulars-announcements__item-date"><?= esc_html( $doc['formatted_date'] ); ?></span>
													<span class="circulars-announcements__item-title"><?= esc_html( $doc['title'] ); ?></span>
													<?php if ( $filesize ) : ?>
													<span class="circulars-announcements__link-icon">
														<img src="<?= esc_url( get_stylesheet_directory_uri() . '/img/pdf-icon.svg' ); ?>" alt="PDF Icon" width="30" height="30" />
														<?= esc_html( $filesize ); ?>
													</span>
													<?php endif; ?>
												</a>
												<?php
											}
											?>
										</div>
									</div>
								</div>
								<?php
								++$year_index;
							}
							?>
							</div>
							<?php
						} else {
							echo '<p class="h3 has-sipco-coral-100-color">Coming soon</p>';
						}
					} else {
						echo '<p class="h3 has-sipco-coral-100-color">Coming soon</p>';
					}
					?>
				</div>
				<?php
				++$index;
			}
			?>
		</div>
	</div>
</section>