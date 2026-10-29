<?php
gp_title( __( 'Projects &lt; GlotPress', 'glotpress' ) );
gp_breadcrumb( array( __( 'Projects', 'glotpress' ) ) );
gp_tmpl_header();
?>

	<div id="projects">
		<div class="backcourt-project-header-card">
			<h2 class="backcourt-projects-title"><?php _e( 'Projects', 'glotpress' ); ?></h2>
			<form action="<?php echo esc_url( gp_url( '/projects' ) ); ?>" method="get" class="project-search-form">
				<div class="project-search-input-wrapper">
					<svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="11" cy="11" r="8"></circle>
						<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
					</svg>
					<input type="text" name="s" id="project-search-input" value="<?php echo isset( $_GET['s'] ) ? esc_attr( wp_unslash( $_GET['s'] ) ) : ''; ?>" placeholder="<?php esc_attr_e( 'Search projects...', 'gp-whitelabel' ); ?>" autocomplete="off" />
					<?php if ( isset( $_GET['s'] ) && '' !== $_GET['s'] ) : ?>
						<a href="<?php echo esc_url( gp_url( '/projects' ) ); ?>" class="clear-search-btn" title="<?php esc_attr_e( 'Clear search', 'gp-whitelabel' ); ?>">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<line x1="18" y1="6" x2="6" y2="18"></line>
								<line x1="6" y1="6" x2="18" y2="18"></line>
							</svg>
						</a>
					<?php endif; ?>
				</div>
				<button type="submit" class="button search-btn"><?php _e( 'Search', 'glotpress' ); ?></button>
			</form>
		</div>

		<?php if ( isset( $_GET['s'] ) && '' !== $_GET['s'] ) : ?>
			<div class="search-results-heading">
				<?php
				printf(
					/* translators: 1: Number of results. 2: Search query. */
					esc_html( _n( 'Found %1$d result for &ldquo;%2$s&rdquo;', 'Found %1$d results for &ldquo;%2$s&rdquo;', count( $projects ), 'gp-whitelabel' ) ),
					count( $projects ),
					esc_html( wp_unslash( $_GET['s'] ) )
				);
				?>
			</div>
		<?php endif; ?>

		<?php if ( empty( $projects ) ) : ?>
			<div class="search-no-results">
				<p><?php _e( 'No projects found matching your search.', 'gp-whitelabel' ); ?></p>
				<?php if ( isset( $_GET['s'] ) && '' !== $_GET['s'] ) : ?>
					<p><a href="<?php echo esc_url( gp_url( '/projects' ) ); ?>" class="button"><?php _e( 'Show all projects', 'gp-whitelabel' ); ?></a></p>
				<?php endif; ?>
			</div>
		<?php else : ?>
			<dl>
				<?php
				foreach ( $projects as $project ) {
					$project_class = $project->active ? 'project-active' : 'project-inactive';
					?>
					<dt class="<?php echo esc_attr( $project_class ); ?>">
						<?php
						$display_name = $project->name;
						// If search query is active and the project has a parent, show its path hierarchy.
						if ( isset( $_GET['s'] ) && '' !== $_GET['s'] && $project->parent_project_id ) {
							$ancestors = array_reverse( $project->path_to_root() );
							$names = array();
							foreach ( $ancestors as $ancestor ) {
								$names[] = $ancestor->name;
							}
							$display_name = implode( ' &rarr; ', $names );
						}
						gp_link_project( $project, esc_html( $display_name ) );
						?>
						<?php gp_link_project_edit( $project, null, array( 'class' => 'button is-small' ) ); ?>
						<?php gp_link_project_delete( $project, null, array( 'class' => 'button is-small' ) ); ?>
						<?php
						if ( ! $project->active ) {
							echo "<span class='inactive bubble'>" . __( 'Inactive', 'glotpress' ) . '</span>';
						}
						?>
					</dt>
					<dd class="<?php echo esc_attr( $project_class ); ?>">
						<?php
						/**
						 * Filter a project description.
						 *
						 * @since 4.0.0
						 *
						 * @param string     $description Project description.
						 * @param GP_Project $project     The project.
						 */
						echo esc_html( gp_html_excerpt( apply_filters( 'gp_project_description', $project->description, $project ), 111 ) );
						?>
					</dd>
					<?php
				}
				?>
			</dl>
		<?php endif; ?>
	</div>
	<div class="clear"></div>

	<p class="actionlist">
		<?php if ( GP::$permission->current_user_can( 'admin' ) ) : ?>
			<?php gp_link( gp_url_project( '-new' ), __( 'Create a New Project', 'glotpress' ) ); ?>  &bull;
		<?php endif; ?>

		<?php gp_link( gp_url( '/languages' ), __( 'Projects by language', 'glotpress' ) ); ?>
	</p>

<?php
gp_tmpl_footer();
