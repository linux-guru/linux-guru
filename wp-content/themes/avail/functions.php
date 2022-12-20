<?php
function avail_css() {
	$parent_style = 'avril-parent-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'avail-style', get_stylesheet_uri(), array( $parent_style ));
	
	wp_enqueue_style('avail-color-default',get_stylesheet_directory_uri() .'/assets/css/color/default.css');
	wp_dequeue_style('avril-default');
	
	wp_enqueue_style('avail-media-query',get_stylesheet_directory_uri().'/assets/css/responsive.css');
	wp_dequeue_style('avril-media-query');
	wp_dequeue_style('avril-fonts');

}
add_action( 'wp_enqueue_scripts', 'avail_css',999);
   	

function avail_setup()	{	

	add_theme_support( 'custom-header', apply_filters( 'avail_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => 'ffffff',
		'width'                  => 2000,
		'height'                 => 200,
		'flex-height'            => true,
		'wp-head-callback'       => 'avril_header_style',
	) ) );
	
	add_editor_style( array( 'assets/css/editor-style.css', avail_google_font() ) );
}
add_action( 'after_setup_theme', 'avail_setup' );
	
/**
 * Register Google fonts for Avail.
 */
function avail_google_font() {
	
   $get_fonts_url = '';
		
    $font_families = array();
 
	$font_families = array('Poppins:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $get_fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

    return $get_fonts_url;
}

function avail_scripts_styles() {
    wp_enqueue_style( 'avail-fonts', avail_google_font(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'avail_scripts_styles' );


/**
 * Called all the Customize file.
 */
require( get_stylesheet_directory() . '/inc/customize/avail-premium.php');


/**
 * Import Options From Parent Theme
 *
 */
function avail_parent_theme_options() {
	$avril_mods = get_option( 'theme_mods_avril' );
	if ( ! empty( $avril_mods ) ) {
		foreach ( $avril_mods as $avril_mod_k => $avril_mod_v ) {
			set_theme_mod( $avril_mod_k, $avril_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'avail_parent_theme_options' );