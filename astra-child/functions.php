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

    // ── VBS-specific styles (only on VBS pages) ──
    if ( astra_child_is_vbs_page() ) {
        wp_enqueue_style(
            'vbs-styles',
            get_stylesheet_directory_uri() . '/vbs.css',
            array( 'astra-child-style' ),
            '1.0.0'
        );
    }
}

/**
 * Helper: Check if the current page is a VBS page.
 * Matches the /vbs page and any child pages (e.g. /vbs/gallery).
 */
function astra_child_is_vbs_page() {
    if ( ! is_page() ) {
        return false;
    }

    $current_id = get_the_ID();

    // Check if this IS the VBS page
    $vbs_page = get_page_by_path( 'vbs' );
    if ( ! $vbs_page ) {
        return false;
    }

    // Current page is VBS, or its parent is VBS
    if ( $current_id === $vbs_page->ID || wp_get_post_parent_id( $current_id ) === $vbs_page->ID ) {
        return true;
    }

    return false;
}
