<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title><?php echo gp_title(); ?></title>

	<?php
	// Enqueue the base style so we don't have to load it manually on each page.
	gp_enqueue_styles( array( 'gp-base' ) );

	gp_head();

	$options   = gp_whitelabel_get_options();
	$logo_type = isset( $options['logo_type'] ) ? $options['logo_type'] : 'default_svg';
	?>
</head>

<body <?php body_class( 'no-js' ); ?>>
	<script type="text/javascript">document.body.className = document.body.className.replace('no-js','js');</script>

	<header class="gp-bar clearfix">
		<h1>
			<div class="backcourt-logo-container">
				<a href="<?php echo esc_url( gp_url( '/' ) ); ?>" rel="home" class="backcourt-logo-link">
					<?php if ( 'custom_image' === $logo_type && ! empty( $options['logo_url'] ) ) : ?>
						<img src="<?php echo esc_url( $options['logo_url'] ); ?>" class="gp-whitelabel-custom-logo" alt="<?php echo esc_attr( $options['brand_name'] ); ?>" />
						<?php if ( ! empty( $options['tagline'] ) ) : ?>
							<div class="backcourt-text-container">
								<span class="backcourt-logo-tagline"><?php echo esc_html( $options['tagline'] ); ?></span>
							</div>
						<?php endif; ?>
					<?php elseif ( 'text_only' === $logo_type ) : ?>
						<div class="backcourt-text-container">
							<span class="gp-whitelabel-brand-title" style="font-size: 1.4rem; font-weight: 700; color: <?php echo esc_attr( $options['header_text'] ); ?>;"><?php echo esc_html( $options['brand_name'] ); ?></span>
							<?php if ( ! empty( $options['tagline'] ) ) : ?>
								<span class="backcourt-logo-tagline"><?php echo esc_html( $options['tagline'] ); ?></span>
							<?php endif; ?>
						</div>
					<?php else : ?>
						<svg class="backcourt-symbol-svg" viewBox="5 0 110 125.2" xmlns="http://www.w3.org/2000/svg">
							<path fill="<?php echo esc_attr( $options['accent_color'] ); ?>" d="M114.8,39.7c0-5.4-2.9-10.4-7.6-13.1L67.5,3.7C62.8,1,57.1,1,52.4,3.7L12.7,26.6 C8,29.3,5.1,34.3,5.1,39.7v45.8c0,5.4,2.9,10.4,7.6,13.1l39.7,22.9c4.7,2.7,10.4,2.7,15.1,0l39.7-22.9c4.7-2.7,7.6-7.7,7.6-13.1 V39.7z M94.1,82c-2.8,0-5.5-1.3-7.6-3.6c-2.2-2.5-3.4-5.8-3.4-9.3v-13c0-3.5,1.2-6.9,3.4-9.3c2.1-2.3,4.8-3.6,7.6-3.6h10.8 c0.1,0.7,0.2,1.4,0.2,2.1v34.6c0,0.7-0.1,1.4-0.2,2.1L94.1,82L94.1,82z M15,82c-0.1-0.7-0.2-1.4-0.2-2.1V45.3 c0-0.7,0.1-1.4,0.2-2.1h10.8c2.8,0,5.5,1.3,7.6,3.6c2.2,2.5,3.4,5.8,3.4,9.3v13c0,3.5-1.2,6.9-3.4,9.3c-2.1,2.3-4.8,3.6-7.6,3.6H15 L15,82z M52.4,110.3L22.4,93c-0.6-0.4-1.2-0.8-1.8-1.2h5.2c11.4,0,20.7-10.2,20.7-22.7v-13c0-12.5-9.3-22.7-20.7-22.7h-5.2 c0.6-0.4,1.2-0.9,1.8-1.2l30-17.3c0.9-0.5,1.8-0.9,2.7-1.2v42.1c-2.1,1.5-3.5,4-3.5,6.8s1.4,5.3,3.5,6.8v42.1 C54.2,111.2,53.3,110.8,52.4,110.3z M67.5,110.3c-0.9,0.5-1.8,0.9-2.7,1.2V69.4c2.1-1.5,3.5-4,3.5-6.8s-1.4-5.3-3.5-6.8V13.7 c0.9,0.3,1.8,0.7,2.7,1.2l30,17.3c0.6,0.4,1.2,0.8,1.8,1.2h-5.2c-11.4,0-20.7,10.2-20.7,22.7v13c0,12.5,9.3,22.7,20.7,22.7h5.2 c-0.6,0.4-1.2,0.9-1.8,1.2L67.5,110.3z"/>
						</svg>
						<div class="backcourt-text-container">
							<svg class="backcourt-wordmark-svg" viewBox="125 0 580 125.2" xmlns="http://www.w3.org/2000/svg">
								<g fill="<?php echo esc_attr( $options['header_text'] ); ?>">
									<path id="b" d="M189.8,59.8l-19.1-11.1c-3.9-2.3-8.8-2.3-12.8,0l-12.3,7.1V14.9c0-3.6-2.9-6.6-6.6-6.6 c-3.6,0-6.6,2.9-6.6,6.6v55.9l0,0v22.1c0,4.6,2.4,8.8,6.4,11l19.1,11.1c3.9,2.3,8.8,2.3,12.8,0l19.1-11.1c3.9-2.3,6.4-6.5,6.4-11 V70.8C196.2,66.3,193.7,62.1,189.8,59.8z M183,85.4c0,4.6-2.4,8.8-6.4,11l-6,3.4c-3.9,2.3-8.8,2.3-12.8,0l-6-3.4 c-3.9-2.3-6.4-6.5-6.4-11v-6.9c0-4.6,2.4-8.8,6.4-11l6-3.4c3.9-2.3,8.8-2.3,12.8,0l6,3.4c3.9,2.3,6.4,6.5,6.4,11V85.4z"/>
									<path id="a" d="M261.7,59.8l-19.1-11.1c-3.9-2.3-8.8-2.3-12.8,0l-19.1,11.1c-3.9,2.3-6.4,6.5-6.4,11v22.1 c0,4.6,2.4,8.8,6.4,11l19.1,11.1c3.9,2.3,8.8,2.3,12.8,0l12.3-7.1v2.3c0,3.6,2.9,6.6,6.6,6.6c3.6,0,6.6-2.9,6.6-6.6v-40 c0-0.6-0.1-1.2-0.3-1.8C267.1,64.8,264.9,61.7,261.7,59.8z M254.9,85.4c0,4.6-2.4,8.8-6.4,11l-6,3.4c-3.9,2.3-8.8,2.3-12.8,0 l-6-3.4c-3.9-2.3-6.4-6.5-6.4-11v-6.9c0-4.6,2.4-8.8,6.4-11l6-3.4c3.9-2.3,8.8-2.3,12.8,0l6,3.4c3.9,2.3,6.4,6.5,6.4,11V85.4z"/>
									<path id="c1" d="M325.2,95.1l-12.3,6c-3.1,1.5-6.8,1.4-9.8-0.4l-8.7-5c-3.2-1.9-5.2-5.3-5.2-9.1v-9.2 c0-3.8,2-7.2,5.2-9.1l8.7-5c3-1.7,6.7-1.9,9.8-0.4l12.3,5.9c3.2,1.6,7.1,0.2,8.7-3c1.6-3.2,0.2-7.1-3-8.7l-18.5-8.9 c-3.1-1.5-6.8-1.4-9.8,0.4l-21.2,12.2c-3.2,1.9-5.2-5.3-5.2,9.1v24.3c0,3.8,2,7.2,5.2,9.1l21.2,12.2c3,1.7,6.7,1.9,9.8,0.4l18.5-9 c3.2-1.6,4.6-5.5,3-8.7C332.4,94.9,328.5,93.5,325.2,95.1z"/>
									<path id="k" d="M390.3,105.4l-27.4-26.1l26.9-20.4c2.9-2.2,3.4-6.4,1.2-9.2c-2.2-2.9-6.4-3.4-9.2-1.2l-26,19.7V15.1 c0-3.6-2.9-6.6-6.6-6.6s-6.6,2.9-6.6,6.6v95.2c0,3.6,2.9,6.6,6.6,6.6s6.6-2.9,6.6-6.6V90.6l25.6,24.5c1.3,1.2,2.9,1.7,4.5,1.7 c1.8,0,3.5-0.7,4.8-2.1C393.1,112,393,107.8,390.3,105.4z"/>
									<path id="c2" d="M444.6,95.1l-12.3,6c-3.1,1.5-6.8,1.4-9.8-0.4l-8.7-5c-3.2-1.9-5.2-5.3-5.2-9.1v-9.2 c0-3.8,2-7.2,5.2-9.1l8.7-5c3-1.7,6.7-1.9,9.8-0.4l12.3,5.9c3.2,1.6,7.1,0.2,8.7-3c1.6-3.2,0.2-7.1-3-8.7l-18.5-8.9 c-3.1-1.5-6.8-1.4-9.8,0.4l-21.2,12.2c-3.2,1.9-5.2-5.3-5.2,9.1v24.3c0,3.8,2,7.2,5.2,9.1l21.2,12.2c3,1.7,6.7,1.9,9.8,0.4l18.5-9 c3.2-1.6,4.6-5.5,3-8.7C451.7,94.9,447.8,93.5,444.6,95.1z"/>
									<path id="o" d="M519.8,60.7l-21.1-12.2c-3.3-1.9-7.3-1.9-10.5,0l-21.1,12.2c-3.3,1.9-5.3,5.4-5.3,9.1v24.3 c0,3.8,2,7.2,5.3,9.1l21.1,12.2c3.3,1.9,7.3,1.9,10.5,0l21.1-12.2c3.3-1.9,5.3-5.4,5.3-9.1V69.8C525.1,66,523.1,62.5,519.8,60.7z M512.1,86.6c0,3.8-2,7.2-5.3,9.1l-8,4.6c-3.3,1.9-7.3,1.9-10.5,0l-8-4.6c-3.3-1.9-5.3-5.4-5.3-9.1v-9.3c0-3.8,2-7.2,5.3-9.1l8-4.6 c3.3-1.9,7.3-1.9,10.5,0l8,4.6c3.3,1.9,5.3,5.4,5.3,9.1V86.6z"/>
									<path id="u" d="M590.1,47.1c-3.6,0.1-6.4,3.1-6.4,6.7v16.3l0,0v16.5c0,3.8-2,7.3-5.3,9.2l-8.1,4.7 c-3.3,1.9-7.3,1.9-10.6,0l-8.1-4.7c-3.3-1.9-5.3-5.4-5.3-9.2V53.7c0-3.7-3-6.7-6.8-6.6c-3.6,0.1-6.4,3.1-6.4,6.7v39.1 c0,4.6,2.4,8.8,6.4,11l19.1,11.1c3.9,2.3,8.8,2.3,12.8,0l12.3-7.1v2.3c0,3.6,2.9,6.6,6.6,6.6c3.6,0,6.6-2.9,6.6-6.6V92.9l0,0V53.6 C596.9,50,593.9,47,590.1,47.1z"/>
									<path id="r" d="M650.1,58l-17.4-10c-2.1-1.2-4.7-1.2-6.7,0l-7.9,3.7c-0.9-2.6-3.3-4.6-6.3-4.6c-3.6,0-6.6,2.9-6.6,6.6 v56.5c0,3.6,2.9,6.6,6.6,6.6s6.6-2.9,6.6-6.6V84.6l0,0V71.5c0-2.4,1.3-4.6,3.4-5.8l4.3-2.5c2.1-1.2,4.7-1.2,6.7,0l10.9,6.3 c3.2,1.8,7.3,0.7,9.1-2.6C654.4,63.8,653.2,59.8,650.1,58z"/>
									<path id="t" d="M700,92.3c-1.8-3.2-5.9-4.2-9-2.4l-16.2,9.4V51.6h12.3c3.6,0,6.6-3,6.6-6.6s-3-6.6-6.6-6.6h-12.3V15 c0-3.6-3-6.6-6.6-6.6s-6.6,3-6.6,6.6v23.4h-12.3c-3.6,0-6.6,3-6.6,6.6s3,6.6,6.6,6.6h12.3v58.6c0,3.6,3,6.6,6.6,6.6 c0.1,0,0.3,0,0.4,0c0.1,0,0.2,0,0.4,0c1.1,0,2.3-0.3,3.3-0.9l25.3-14.6C700.7,99.5,701.8,95.4,700,92.3z"/>
								</g>
							</svg>
							<?php if ( ! empty( $options['tagline'] ) ) : ?>
								<span class="backcourt-logo-tagline"><?php echo esc_html( $options['tagline'] ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</a>
			</div>
		</h1>

		<nav id="main-navigation" role="navigation">
			<?php echo gp_nav_menu(); ?>
		</nav>

		<nav id="side-navigation">
			<?php echo gp_nav_menu( 'side' ); ?>
		</nav>
	</header>

	<div class="gp-content">
		<?php echo gp_breadcrumb(); ?>

		<div id="gp-js-message" class="gp-js-message"></div>

		<?php if ( gp_notice( 'error' ) ) : ?>
			<div class="error">
				<?php echo gp_notice( 'error' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( gp_notice() ) : ?>
			<div class="notice">
				<?php echo gp_notice(); ?>
			</div>
		<?php endif; ?>

		<?php
		/**
		 * Fires after the error and notice elements on the header.
		 *
		 * @since 1.0.0
		 */
		do_action( 'gp_after_notices' );
