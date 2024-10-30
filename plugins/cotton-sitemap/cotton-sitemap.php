<?php
/**
 * Dynamically generate a sitemap.xml url for Crawlers
 *
 * Points sitemap.xml to this file
 * Includes all posts in a sitemap format
 * Rules are flushed in Cotton_Framework->register_activation_hook()
 *
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */

if( !is_admin() )
	new Cotton_Sitemap;

class Cotton_Sitemap {
	
	function Cotton_Sitemap()
	{
		register_activation_hook( __FILE__, array(&$this, 'register_activation_hook') );
		add_action( 'init', array(&$this, 'init') );
		add_action( 'generate_rewrite_rules', array(&$this, 'generate_rewrite_rules') );
	} // function
	
	function register_activation_hook()
	{
		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	} // function
	
	function init()
	{
		if($_SERVER['REQUEST_URI'] == '/sitemap.xml') {
			header ("Content-Type:text/xml"); 
			echo $this->get_sitemap();
			die();
		} // if
	} // function
	
	function generate_rewrite_rules( $wp_rewrite )
	{
		$feed_rules = array(
			'sitemap.xml$' => COTTON_PLUGIN_URL . '/cotton-sitemap.php'
		);

		$wp_rewrite->rules = $feed_rules + $wp_rewrite->rules;
	} // function
	
	function get_sitemap()
	{
		# See Protocol at http://www.sitemaps.org/protocol.php
		$output = "";
		$output .= "<?xml version='1.0' encoding='UTF-8'?>\n";
		$output .= "<urlset xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xsi:schemaLocation='http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd' xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\r";
		
		$site_url = trailingslashit(get_bloginfo('url'));

		$output .= "\t<url>\n";
		$output .= "\t\t<loc>$site_url</loc>\n";
#		$output .= "\t\t<lastmod>2010-05-18</lastmod>\n";
		$output .= "\t\t<changefreq>daily</changefreq>\n";
		$output .= "\t\t<priority>1.0</priority>\n";
		$output .= "\t</url>\n";
		
		$args = array(
		#	'post_type' => 'any'
			'post_type' => array('page','post')
			);
		$query = new WP_Query($args);
		if( $query->have_posts() ) {
			while( $query->have_posts() ) {
				$query->the_post();
				
				$priority = 0;
				switch( get_post_type() ) {
					case 'page':
						$changefreq = "weekly";
						$priority = 0.8;
						break;
					case 'post':
						$changefreq = "weekly";
						$priority = 0.5;
						break;
					default:
						$changefreq = "weekly";
						$priority = 0.1;
						break;
				} // switch
				
				$output .= "\t<url>\n";
				$output .= "\t\t<loc>".get_permalink()."</loc>\n";
				$output .= "\t\t<lastmod>".the_modified_date('Y-m-d', null, null, false)."</lastmod>\n";
				$output .= "\t\t<changefreq>$changefreq</changefreq>\n";
				$output .= "\t\t<priority>$priority</priority>\n";
				$output .= "\t</url>\n";
				
			} // while
		} // if
		
		$output .= "</urlset>";
		return trim($output);
	} // function
	
} // class

?>