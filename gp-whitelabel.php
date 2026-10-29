<?php
/**
 * Plugin Name: Whitelabel Customization for GlotPress
 * Description: White-labels GlotPress to match your brand identity, custom logo, tagline, fonts, and color schemes via a dedicated Customizer page.
 * Version: 1.0.1
 * Author: helgatheviking
 * Author URI: https://github.com/helgatheviking
 * License: GPLv2 or later
 * Text Domain: gp-whitelabel
 * Domain Path: /languages
 * Update URI: https://www.backcourt.io
 */

use HelgaTheViking\GP_Whitelabel\Vendor\Fragen;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load the namespace-prefixed vendor libraries and the Git Updater Lite updater.
if ( file_exists( __DIR__ . '/vendor-prefixed/autoload.php' ) ) {
	require_once __DIR__ . '/vendor-prefixed/autoload.php';
	if ( class_exists( Fragen\Git_Updater\Lite::class ) ) {
		( new Fragen\Git_Updater\Lite( __FILE__ ) )->run();
	}
}

// Load Admin Settings Page & Options.
require_once plugin_dir_path( __FILE__ ) . 'includes/admin-settings.php';

/**
 * Register custom styles for GlotPress.
 */
function gp_whitelabel_register_styles() {
	$css_file = plugin_dir_path( __FILE__ ) . 'assets/css/style.css';
	$version  = file_exists( $css_file ) ? filemtime( $css_file ) : '1.0.0';

	wp_register_style(
		'glotpress-whitelabel-css',
		plugins_url( 'assets/css/style.css', __FILE__ ),
		array( 'gp-base' ),
		$version
	);
}
add_action( 'init', 'gp_whitelabel_register_styles' );

/**
 * Enqueue custom style in GlotPress templates and inject dynamic CSS custom properties.
 */
function gp_whitelabel_enqueue_styles( $template, $args ) {
	if ( function_exists( 'gp_enqueue_style' ) ) {
		gp_enqueue_style( 'glotpress-whitelabel-css' );

		$options = gp_whitelabel_get_options();

		$header_bg             = esc_attr( $options['header_bg'] );
		$header_text           = esc_attr( $options['header_text'] );
		$accent_color          = esc_attr( $options['accent_color'] );
		$btn_primary_bg        = esc_attr( $options['btn_primary_bg'] );
		$btn_primary_text      = esc_attr( $options['btn_primary_text'] );
		$btn_primary_hover_bg  = esc_attr( $options['btn_primary_hover_bg'] );
		$btn_primary_hover_text = esc_attr( $options['btn_primary_hover_text'] );
		$logo_height           = absint( $options['logo_height'] );

		$custom_css = "
			:root {
				--gp-color-header-bg: {$header_bg};
				--gp-color-header-text: {$header_text};
				--gp-color-header-item-hover-border: {$accent_color};
				--gp-color-header-item-current-border: {$accent_color};
				--gp-color-primary: {$accent_color};
				--gp-color-accent-fg: {$header_bg};
				--gp-color-accent-emphasis: {$header_bg};
				--gp-color-btn-text: {$header_bg};
				--gp-color-btn-border: {$header_bg};
				--gp-color-btn-hover-text: {$accent_color};
				--gp-color-btn-hover-border: {$accent_color};
				--gp-color-btn-primary-bg: {$btn_primary_bg};
				--gp-color-btn-primary-text: {$btn_primary_text};
				--gp-color-btn-primary-border: {$btn_primary_bg};
				--gp-color-btn-primary-hover-bg: {$btn_primary_hover_bg};
				--gp-color-btn-primary-hover-text: {$btn_primary_hover_text};
				--gp-color-btn-primary-hover-border: {$btn_primary_hover_bg};
			}
			.gp-bar { background-color: {$header_bg} !important; color: {$header_text} !important; }
			.gp-table th { background-color: {$btn_primary_bg} !important; color: {$btn_primary_text} !important; }
			.backcourt-logo-tagline, .gp-whitelabel-logo-tagline { color: {$accent_color} !important; }
			.gp-bar a:hover, .gp-bar a:focus, .gp-bar a.current { color: {$accent_color} !important; }
			.backcourt-symbol-svg path { fill: {$accent_color} !important; }
			.backcourt-projects-title { color: {$header_bg} !important; }
			.gp-whitelabel-custom-logo { max-height: {$logo_height}px !important; width: auto !important; display: block; }
		";

		wp_add_inline_style( 'glotpress-whitelabel-css', $custom_css );
	}
}
add_action( 'gp_pre_tmpl_load', 'gp_whitelabel_enqueue_styles', 10, 2 );

/**
 * Add plugin's templates folder to the GlotPress template loading locations.
 */
function gp_whitelabel_tmpl_locations( $locations, $template, $args, $template_path ) {
	array_unshift( $locations, plugin_dir_path( __FILE__ ) . 'templates/' );
	return $locations;
}
add_filter( 'gp_tmpl_load_locations', 'gp_whitelabel_tmpl_locations', 10, 4 );

/**
 * Filter the header home page link title.
 */
function gp_whitelabel_home_title( $title ) {
	$options = gp_whitelabel_get_options();
	return ! empty( $options['brand_name'] ) ? $options['brand_name'] : $title;
}

if ( ! is_admin() ) {
	add_filter( 'gp_home_title', 'gp_whitelabel_home_title' );
}

/**
 * Filter projects list to support searching projects on the main projects page.
 *
 * @param array $projects           Array of projects.
 * @param int   $parent_project_id  Parent project ID.
 * @return array Filtered projects list.
 */
function gp_whitelabel_filter_projects( $projects, $parent_project_id ) {
	if ( ( 0 === $parent_project_id || null === $parent_project_id ) && isset( $_GET['s'] ) ) {
		$search = sanitize_text_field( wp_unslash( $_GET['s'] ) );
		if ( ! empty( $search ) ) {
			global $wpdb;
			$gp_project = GP::$project;
			$like = '%' . $wpdb->esc_like( $search ) . '%';
			$projects = $gp_project->many(
				"SELECT * FROM {$gp_project->table} WHERE name LIKE %s OR description LIKE %s OR slug LIKE %s ORDER BY active DESC, name ASC",
				$like, $like, $like
			);
		}
	}
	return $projects;
}
add_filter( 'gp_projects', 'gp_whitelabel_filter_projects', 10, 2 );

/**
 * Show WordPress Admin Bar if the user has the authority to view the admin (manage_options).
 *
 * @param bool $show Whether to show the admin bar.
 * @return bool Modified show status.
 */
function gp_whitelabel_show_admin_bar( $show ) {
	if ( current_user_can( 'manage_options' ) ) {
		return true;
	}
	return $show;
}
add_filter( 'show_admin_bar', 'gp_whitelabel_show_admin_bar' );

