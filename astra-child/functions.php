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

/**
 * Force 'Full Width / Stretched' layout on VBS pages.
 * Bypasses Astra Customizer and individual page settings.
 */
add_filter( 'astra_get_content_layout', 'vbs_force_stretched_layout' );


/**
 * Add custom Open Graph meta tags for VBS 2026 Page (ID 3)
 */
function vbs_custom_og_tags() {
    if ( is_page( 3 ) ) {
        echo "\n" . '<!-- Custom VBS Open Graph Tags -->' . "\n";
        echo '<meta property="og:title" content="VBS 2026 - Join the Adventure!" />' . "\n";
        echo '<meta property="og:description" content="Register now for a week of fun and learning at AdventHope Atlanta." />' . "\n";
        echo '<meta property="og:image" content="https://adventhopeatlanta.org/wp-content/uploads/2026/04/wonderfully-made.jpeg" />' . "\n";
        echo '<meta property="og:image:width" content="1200" />' . "\n";
        echo '<meta property="og:image:height" content="630" />' . "\n";
        echo '<meta property="og:type" content="website" />' . "\n";
        echo '<meta property="og:url" content="' . esc_url( get_permalink() ) . '" />' . "\n";
    }
}
add_action( 'wp_head', 'vbs_custom_og_tags', 1 );
function vbs_force_stretched_layout( $layout ) {
    // Target VBS pages by slug or title to force Astra's full-width stretched container
    if ( is_page( array( 'vbs', 'vbs-2026', 'gallery', 'previous-event-gallery' ) ) ) {
        return 'page-builder'; // Astra's internal slug for 'Full Width / Stretched'
    }
    return $layout;
}
