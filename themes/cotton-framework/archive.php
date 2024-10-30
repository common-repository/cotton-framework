<?php 
/**
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
get_header(); 
?>
<?php get_sidebar('left'); ?>
<div class="grid_10 not-sidebar">
	<ul class="manageable" id="archive-header-widget">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Archive Header') ) : ?>
		<li></li>
	<?php endif; ?>
	</ul>

	<?php get_template_part('loop', 'archive'); ?>

	<ul class="manageable" id="archive-footer-widget">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Archive Footer') ) : ?>
		<li></li>
	<?php endif; ?>
	</ul>
</div>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>