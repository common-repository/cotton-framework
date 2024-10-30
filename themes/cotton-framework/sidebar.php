<?php 
/**
 * Global Sidebar Controller
 * 
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
global $sidebar_label,$sidebar_class;
if( empty($sidebar_label) ){
	$sidebar_label = '';
	$sidebar_class = '';
}
?>
<div class="grid_5 sidebar <?php echo $sidebar_class; ?>">
	<ul class="manageable sidebar-widgets">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($sidebar_label) ) : ?>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : ?>
			<li class="widget widget_recent_entries">
				<h3 class="widgettitle">Recent Posts</h3>
					<ul>
						<?php wp_get_archives('type=postbypost&limit=10&format=html'); ?>
					</ul>
			</li>
			<li class="widget widget_search">
				<h3 class="widgettitle">Search</h3>
				<ul>
					<li><?php get_search_form(); ?></li>
				</ul>
			</li>
			<li class="widget widget_archives">
				<h3 class="widgettitle">Archives</h3>
					<ul>
						<?php wp_get_archives(); ?>
					</ul>
			</li>
		<?php endif; ?>
	<?php endif; ?>
	</ul>
</div>