<?php 
/**
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
header("HTTP/1.0 404 Not Found");
global $wp_query;
$wp_query->is_404 = true;
get_template_part('search');
?>