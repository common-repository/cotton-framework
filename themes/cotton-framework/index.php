<?php 
/**
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
global $cotton_functions;
get_header();
get_sidebar('left');
?>
<div class="grid_10 not-sidebar">
	<?php if(is_front_page()): ?>
		<ul class="manageable" id="front-page-header-widget">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Front Page Header') ) : ?>
			<li></li>
		<?php endif; ?>
		</ul>
	<?php endif; ?>
	
	<?php get_template_part('loop', 'index'); ?>
	
	<?php if(is_front_page()): ?>
		<ul class="manageable" id="front-page-footer-widget">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Front Page Footer') ) : ?>
			<li></li>
		<?php endif; ?>
		</ul>
	<?php endif; ?>
</div>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>