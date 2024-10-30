<?php
/**
 * Handles WordPress Natural Filters
 *
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1.2
 */
new Cotton_Framework_Theme_Filters;

class Cotton_Framework_Theme_Filters extends Cotton_Framework_Theme {
	
	/**
	 * Filters
	 */
	function Cotton_Framework_Theme_Filters()
	{
		if( function_exists('add_filter') ):
			add_filter( 'wp_title', array( &$this, 'wp_title' ) );
			add_filter( 'body_class', array( &$this, 'body_class' ) );
			add_filter( 'post_class', array( &$this, 'post_class' ) );
			add_filter( 'mce_css', array( &$this, 'mce_css' ) );
			add_filter( 'wp_nav_menu_args', array( &$this, 'wp_nav_menu_args' ) );
			add_filter( 'the_author_posts_link', array( &$this, 'the_author_posts_link' ) );
		endif;
	} // class
	
	function wp_title( $title = '' )
	{
		$frontpage_post_category = parent::get_option('frontpage-post-category');
		if( parent::is_front_page_url() && !empty($frontpage_post_category) && $frontpage_post_category != 'default' ):
			$title = '';
		endif;
		return $title;
	} // function
	
	function body_class($classes = '')
	{
		if( parent::get_option('sidebar-layout') ) {
			$classes[] = parent::get_option('sidebar-layout');
		} else {
			$classes[] = "sidebar-r";
		}
		$classes[] = strtolower(get_stylesheet());
		return $classes;
	} // function
	
	function post_class( $classes = '' )
	{
		global $post;
		if( is_sticky( $post->ID ) && !in_array( 'sticky', $classes ) )
			$classes[] = "sticky";
			
		return $classes;
	} // function
	
	function mce_css($url) {
	  if ( !empty($url) )
	    $url .= ',';

	  $url .= get_template_directory_uri() . '/styles/cotton.css';

	  return $url;
	} // function
	
	function wp_nav_menu_args( $args = '' )
	{
		$args['container'] = '';
		return $args;
	} // function
	
	function the_author_posts_link( $author )
	{
		$expose_authors = parent::get_option( 'expose-authors' );
		if( !$expose_authors )
			$author = get_the_author();
		
		return $author;
	} // function
	
} // class

?>