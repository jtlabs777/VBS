<?php
/**
 * Astra Child Theme — functions.php
 * Advent Hope Atlanta
 *
 * Enqueues parent styles and conditionally loads VBS-specific assets.
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue parent and child theme stylesheets.
 */
add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_styles' );
function astra_child_enqueue_styles() {

    // Parent theme styles (Astra)
    wp_enqueue_style(
        'astra-theme-css',
        get_template_directory_uri() . '/style.css',
        array(),
        wp_get_theme( 'astra' )->get( 'Version' )
    );

    // Child theme styles
    wp_enqueue_style(
        'astra-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'astra-theme-css' ),
        '1.0.0'
    );

    // ── VBS-specific styles (load on all pages to ensure it works regardless of slug/caching) ──
    $vbs_css_path = get_stylesheet_directory() . '/vbs.css';
    $vbs_css_ver  = file_exists( $vbs_css_path ) ? filemtime( $vbs_css_path ) : '1.0.2';

    wp_enqueue_style(
        'vbs-styles',
        get_stylesheet_directory_uri() . '/vbs.css',
        array( 'astra-child-style' ),
        $vbs_css_ver
    );
}
