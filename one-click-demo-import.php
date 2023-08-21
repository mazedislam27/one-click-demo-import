<?php 
/*Import content data*/
if ( ! function_exists( 'mazedulislam27_import_files' ) ) :
function mazedulislam27_import_files() {
    return array(
        array(
			 'import_file_name'             => esc_html__( 'Demo Data', 'mazedulislam27' ),
			'local_import_file'            => trailingslashit(get_template_directory()) . 'inc/demo/demo-data.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo/widgets.wie',
            'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo/customizer.dat',
            'import_preview_image_url'   => 'http://www.mazedit.com/mazedulislam/screenshot.png',
			'import_notice'                => esc_html__( 'Please install all the required plugins before installing demo data.', 'mazedulislam27' ),
        ),
    );
}
add_filter( 'pt-ocdi/import_files', 'mazedulislam27_import_files' );
endif;


// Assign Menu after import
if ( ! function_exists( 'mazedulislam27_after_import' ) ) :
function mazedulislam27_after_import( $selected_import ) {
 
    if ( 'Demo Data' === $selected_import['import_file_name'] ) :
        //Set Menu
        $primary        = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
        set_theme_mod( 'nav_menu_locations' , array( 
                'primary_menu' => $primary->term_id, 
            ) 
        );

       //Set Front page
       $page = get_page_by_title( 'Home');
       if ( isset( $page->ID ) ):
        update_option( 'page_on_front', $page->ID );
        update_option( 'show_on_front', 'page' );
       endif;
       
       //import codestar framework demo data
       global $wp_filesystem;
        $file = get_template_directory().'/inc/demo/theme-options.txt';
        if ( function_exists( 'cs_get_option' ) && file_exists( $file ) ):
            $data =  $wp_filesystem->get_contents( $file );
            $decoded_data = cs_decode_string ( $data );
            update_option( '_cs_options', $decoded_data );
        endif; 
              
    endif;
    
}
add_action( 'pt-ocdi/after_import', 'mazedulislam27_after_import' );
endif;

