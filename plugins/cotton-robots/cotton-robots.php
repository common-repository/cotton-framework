<?php
/**
 * Dynamically generate a robots.txt url for Crawlers
 *
 * Points robots.txt to this file
 * Protects your private files from Crawlers
 * Only enabled if the blog is public to search engines.
 * Rules are flushed in Cotton_Framework->register_activation_hook()
 *
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */

if( '0' != get_option( 'blog_public' ) && !is_admin() )
	new Cotton_Robots;

class Cotton_Robots {
	
	function Cotton_Robots()
	{
		add_action( 'generate_rewrite_rules', array(&$this, 'generate_rewrite_rules') );
		add_filter( 'robots_txt', array(&$this, 'robots_txt') );
	} // function
	
	function generate_rewrite_rules( $wp_rewrite )
	{
		$feed_rules = array(
			'robots.txt$' => 'index.php/?robots=1'
		);

		$wp_rewrite->rules = $feed_rules + $wp_rewrite->rules;
	} // function
	
	function robots_txt()
	{
		# See Protocol at http://www.robotstxt.org/
		$site_url = get_bloginfo('url');
		
		$output = "";
		$output .= "User-agent: *\n";
		$output .= "Disallow: \?.*\n";
		$output .= "Disallow: /cgi-bin\n";
		$output .= "Disallow: /wp-admin\n";
		$output .= "Disallow: /wp-includes\n";
		$output .= "Disallow: /wp-content/cache\n";
		$output .= "Disallow: /wp-content/plugins\n";
		$output .= "Disallow: /wp-content/themes\n";
		$output .= "Disallow: /feed\n";
		$output .= "Disallow: /*/feed\n";
		$output .= "Disallow: /comments\n";
		$output .= "Disallow: /author\n";
		$output .= "Disallow: /tag\n";
		$output .= "Disallow: /archives\n";
		$output .= "Disallow: */trackback\n";
		$output .= "Disallow: /*.php$\n";
		$output .= "Disallow: /*.js$\n";
		$output .= "Disallow: /*.inc$\n";
		$output .= "Disallow: /*.css$\n";
		$output .= "Disallow: /*.gz$\n";
		$output .= "Disallow: /*.wmv$\n";
		$output .= "Disallow: /*.cgi$\n";
		$output .= "Disallow: /*.doc$\n";
		$output .= "Disallow: /*.zip$\n";
		$output .= "Sitemap: $site_url/sitemap.xml";
		
		return $output;
	} // function
	
} // class

?>