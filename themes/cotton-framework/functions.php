<?php
/**
 * Handles Framework Setup
 *
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
global $cotton_functions;
$cotton_functions = new Cotton_Framework_Theme;

class Cotton_Framework_Theme {
	
	function Cotton_Framework_Theme()
	{	
		global $wp_version;
		if( empty($wp_version) )
			die('Please visit http://wordpress.org/extend/plugins/cotton-framework/ for installation notes.');
		
		include 'functions-hooks.php';
		include 'functions-filters.php';
		
		if( function_exists('add_action') ):
			add_action( 'cotton_header', array( &$this, 'header' ) );
			add_action( 'cotton_footer', array( &$this, 'footer' ) );
			add_action( 'cotton_body_id', array( &$this, 'body_id' ) );
			add_action( 'cotton_paginate_links', array(&$this, 'paginate_links') );
		endif;
	} // function
	
	function is_front_page_url()
	{
		$this_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$blog_url = get_bloginfo('url') . "/";
		if( $blog_url == $this_url )
			return true;
		else
			return false;
	} // function
	
	function front_page_category()
	{
		if( is_front_page() ):
			$frontpage_post_category = $this->get_option('frontpage-post-category');
			if( 'posts' == get_option('show_on_front') && !empty($frontpage_post_category) && $frontpage_post_category != 'default' ):
				$args = array(
					'cat' => $this->get_option('frontpage-post-category')
					);
				query_posts( $args );
				global $wp_query;
				$wp_query->is_archive = false;
				$wp_query->is_category = false;
				$wp_query->is_home = true;
				$this->sticky_posts_first();
			endif;
		endif;
	} // function
	
	/** Similar to wp-includes/query.php Line 2473 */
	function sticky_posts_first()
	{
		global $wp_query;
		$sticky_posts = get_option( 'sticky_posts' );
		$posts = $wp_query->posts;
		$num_posts = count($posts);
		$sticky_offset = 0;
		for ( $i = 0; $i < $num_posts; $i++ ) {
			if ( in_array($posts[$i]->ID, $sticky_posts) ) {
				$sticky_post = $posts[$i];
				// Remove sticky from current position
				array_splice($posts, $i, 1);
				// Move to front, after other stickies
				array_splice($posts, $sticky_offset, 0, array($sticky_post));
				// Increment the sticky offset.  The next sticky will be placed at this offset.
				$sticky_offset++;
				// Remove post from sticky posts array
				$offset = array_search($sticky_post->ID, $sticky_posts);
				unset( $sticky_posts[$offset] );
			} // if
		} // for
		$wp_query->posts = $posts;
	} // function
	
	function header( $args = '' )
	{
		$defaults = array(
			'url' => get_bloginfo('url'),
			'title' => get_bloginfo('name'),
			'description' => get_bloginfo('description')
			);
		
		$args = wp_parse_args( $args, $defaults );
		
		extract( $args, EXTR_SKIP );
		
		$html = "<h1 class='site-title'><a href='$url' title='$title - $description' rel='home'>$title</a></h1>";
		$html .= "<h2 class='site-description'>$description</h2>";
		
		$html = apply_filters( 'cotton_header_html', $html );
		
		echo $html;
	} // function
	
	function footer( $args = '' )
	{
		$defaults = array(
			'url' => get_bloginfo('url'),
			'title' => get_bloginfo('name'),
			'description' => get_bloginfo('description')
			);
		
		$args = wp_parse_args( $args, $defaults );
		
		extract( $args, EXTR_SKIP );
		
		$html = "<ul>";
		$html .= "<li><a href='$url' title='$title - $description' rel='home'>$title</a></li>";
		$html .= "<li>$description</li>";
		$html .= "</ul>";
		
		
		$html = apply_filters( 'cotton_footer_html', $html );
		
		echo $html;
	} // function
	
	function paginate_links($args = '')
	{
		echo $this->get_paginate_links($args);
	} // function
	
	function get_paginate_links($args = '')
	{
		global $wp_query, $wp_rewrite;
		get_query_var('paged') > 1 ? $current = get_query_var('paged') : $current = 1;
		
		$defaults = array(
			'base' => @add_query_arg('page','%#%'),
			'format' => '',
			'total' => $wp_query->max_num_pages,
			'current' => $current,
			'show_all' => true,
			'type' => 'list',
			);
		
		if( $wp_rewrite->using_permalinks() )
			$defaults['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');

		if( !empty($wp_query->query_vars['s']) )
			$defaults['add_args'] = array('s'=>get_query_var('s'));
		
		$args = wp_parse_args( $args, $defaults );
		
		$args = apply_filters( 'cotton_paginate_links_args', $args );
		
		return paginate_links($args);
	} // function
	
	function get_option( $option )
	{
		global $cotton;
		if( !empty($cotton) )
			return $cotton->settings->settings_values[$option];
	} // function
	
	function meta_description()
	{
		$output = "";
		
		if( is_single() ) {
			$output .= get_the_date('M j, Y') . " ... " . get_the_excerpt();
		} else if( is_page() ) {
			global $post;
			$output = wp_trim_excerpt($post->post_content);
		} else {
			$output = get_bloginfo('description');
		} // if, else
		
		$output = "<meta name='description' content='$output'/>\r\n";
		
	 	echo apply_filters( 'cotton_meta_description_output', $output );
	} // function
	
	function site_verification()
	{
		$output = '';
		if( $verification = $this->get_option( 'google-site-verification' ) ) 
			$output .= "<meta name='google-site-verification' content='$verification' />\r\n";
			
		if( $verification = $this->get_option( 'bing-site-verification' ) ) 
			$output .= "<meta name='msvalidate.01' content='$verification' />\r\n";
			
		echo apply_filters( 'cotton_site_verification_output', $output );
	} // function
	
	function body_id()
	{
		if( 1 == $this->get_option( 'cotton-mobile' ) ) 
			$output = "id='handheld'";
			
		return apply_filters( 'cotton_body_id_output', $output );
	} // function
	
	function google_analytics()
	{
		if( $this->get_option('google-analytics-id') && file_exists( get_template_directory() . '/scripts/google-analytics.js.php' ) ):
			$google_analytics_id = apply_filters( 'cotton_google_analytics_id', $this->get_option('google-analytics-id') );
			define( 'GOOGLE_ANALYTICS_ID', $google_analytics_id );
			include get_template_directory() . '/scripts/google-analytics.js.php';
		endif;
	} // function
	
} // class

?>