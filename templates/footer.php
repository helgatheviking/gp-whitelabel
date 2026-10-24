	</div>
	<footer id="gp-footer" class="gp-footer">
		<div class="gp-footer-credits">
			<p class="gp-footer-copyright">&copy;
				<?php
				echo date_i18n(
					/* translators: Copyright date format, see https://www.php.net/manual/datetime.format.php */
					_x( 'Y', 'copyright date format', 'glotpress' )
				);
				?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			</p>

			<?php
			if ( function_exists( 'the_privacy_policy_link' ) ) {
				the_privacy_policy_link( '<p class="gp-privacy-policy">', '</p>' );
			}

			$options            = gp_whitelabel_get_options();
			$footer_powered_by  = isset( $options['footer_powered_by'] ) && '' !== trim( $options['footer_powered_by'] ) ? $options['footer_powered_by'] : 'Powered by <a rel="nofollow" href="https://www.backcourt.io/">Backcourt Translations</a>';
			?>

			<p class="gp-powered-by">
				<?php echo wp_kses_post( $footer_powered_by ); ?>
			</p>

			<?php if ( current_user_can( 'manage_options' ) ) : ?>
				<p class="gp-admin-dashboard-link">
					<a href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Admin Dashboard', 'glotpress-whitelabel' ); ?></a>
				</p>
			<?php endif; ?>
		</div>

		<?php gp_footer(); ?>
	</footer>
	</body>
</html>
