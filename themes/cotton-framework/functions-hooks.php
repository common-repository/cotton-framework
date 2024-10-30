<?php
/**
 * Handles WordPress Natural Hooks
 *
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1.2
 */
new Cotton_Framework_Theme_Hooks;

class Cotton_Framework_Theme_Hooks extends Cotton_Framework_Theme {
	
	/**
	 * Hooks
	 */
	function Cotton_Framework_Theme_Hooks()
	{
		if( function_exists('remove_action') ):
			remove_action( 'wp_head', 'wp_generator' );
			remove_action( 'wp_head', 'rsd_link' );
			remove_action( 'wp_head', 'wlwmanifest_link' );
		endif;
		
		if( function_exists('add_action') ):
			add_action( 'init', array( &$this, 'init' ) );
			add_action( 'template_redirect', array( &$this, 'template_redirect' ) );
			add_action( 'wp_print_styles', array( &$this, 'wp_print_styles' ) );
			add_action( 'wp_head', array( &$this, 'wp_head' ) );
			add_action( 'wp_footer', array( &$this, 'wp_footer' ) );
		endif;
	} // function
	
	function init()
	{
		/** @link http://codex.wordpress.org/Function_Reference/add_theme_support */
		if( function_exists('add_theme_support') ):
			add_theme_support( 'automatic-feed-links' );
		#	add_theme_support('post-thumbnails');
		endif;
		
		$advanced_widgets = $this->get_option('advanced-widgets');
		
		$sidebars = array();
		$sidebars[] = array( 'name' => 'Site Header', 'description' => 'Header for the entire site' );
		if( $advanced_widgets ):
			$sidebars[] = array( 'name' => 'Header Navigation', 'description' => 'Navigation for the top of the entire site' );
		else:
			$sidebars[] = array( 'name' => 'Navigation', 'description' => 'Navigation for the top and bottom of the entire site' );
		endif;
		$sidebars[] = array( 'name' => 'Content Header', 'description' => 'Content Header for the entire site' );
		$sidebars[] = array( 'name' => 'Sidebar Left', 'description' => 'Left Sidebar for the entire site' );
		$sidebars[] = array( 'name' => 'Sidebar Right', 'description' => 'Right Sidebar for the entire site' );
		$sidebars[] = array( 'name' => 'Content Footer', 'description' => 'Content Footer for the entire site' );
		if( $advanced_widgets )
			$sidebars[] = array( 'name' => 'Footer Navigation', 'description' => 'Navigation for the bottom of the entire site' );
		$sidebars[] = array( 'name' => 'Site Footer', 'description' => 'Footer for the entire site' );
		
		if( $advanced_widgets ) {
			$sidebars[] = array( 'name' => 'Front Page Header', 'description' => 'Header before The Loop for the Front Page only' );
			$sidebars[] = array( 'name' => 'Front Page Footer', 'description' => 'Footer after The Loop for the Front Page only' );
			$sidebars[] = array( 'name' => 'Page Header', 'description' => 'Header before The Loop for Pages only' );
			$sidebars[] = array( 'name' => 'Page Footer', 'description' => 'Footer after The Loop for Pages only' );
			$sidebars[] = array( 'name' => 'Single Header', 'description' => 'Header before The Loop for Single Posts only' );
			$sidebars[] = array( 'name' => 'Single Footer', 'description' => 'Footer after The Loop for Single Posts only' );
			$sidebars[] = array( 'name' => 'Search Header', 'description' => 'Header before The Loop for the Search Page only' );
			$sidebars[] = array( 'name' => 'Search Footer', 'description' => 'Footer after The Loop for the Search Page only' );
			$sidebars[] = array( 'name' => 'Archive Header', 'description' => 'Header before The Loop for Archives, Dates, Categories, Tags and Taxonomies only' );
			$sidebars[] = array( 'name' => 'Archive Footer', 'description' => 'Footer after The Loop for Archives, Dates, Categories, Tags and Taxonomies only' );
			$sidebars[] = array( 'name' => 'Author Header', 'description' => 'Header before The Loop for Author Pages only' );
			$sidebars[] = array( 'name' => 'Author Footer', 'description' => 'Footer after The Loop for Author Pages only' );
		}
		
		if ( function_exists('register_sidebar') ):
			if( empty($sidebars) )
				return false;
				
			$sidebars = apply_filters( 'cotton_sidebars', $sidebars );

			$defaults = array(
				'name' => 'Cotton Sidebar',
				'description' => "A Cotton Framework Widget Area",
				'before_title' => "<h3 class='widgettitle'>",
				'after_title' => "</h3>"
				);
			
			foreach($sidebars as $args) {
				$args = wp_parse_args( $args, $defaults );
				register_sidebar($args);
			} // foreach
		endif;
	} // function
	
	function template_redirect() 
	{
		if( !have_posts() ):
			locate_template( array('404.php'), true);
			die();
		endif;
		parent::front_page_category();
		if( is_singular() ) wp_enqueue_script( 'comment-reply' );
	} // function
	
	function wp_print_styles()
	{
		wp_register_style('cotton', get_template_directory_uri() . "/styles/cotton.css", array(), false, 'all');
		wp_enqueue_style( 'cotton' );
		
		wp_register_style('print', get_template_directory_uri() . "/styles/print.css", array(), false, 'print');
		wp_enqueue_style( 'print' );
		
		wp_register_style('style', get_bloginfo('stylesheet_url'), array(), false, 'screen, handheld' );
		wp_enqueue_style( 'style' );
	} // function
	
	function wp_head()
	{
		parent::meta_description();
		parent::site_verification();
	} // function
	
	function wp_footer()
	{
		parent::google_analytics();
	} // function
	
} // class

?>