<?php 
/**
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
get_header(); 
?>
<?php get_template_part('sidebar','left'); ?>
<div class="grid_10 not-sidebar">
	<?php if(is_front_page()): ?>
		<ul class="manageable" id="home-header-widget">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Header') ) : ?>
			<li></li>
		<?php endif; ?>
		</ul>
	<?php else: ?>
		<ul class="manageable" id="page-header-widget">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Header') ) : ?>
			<li></li>
		<?php endif; ?>
		</ul>
	<?php endif; ?>

	<?php get_template_part('loop', 'page'); ?>

	<?php if(is_front_page()): ?>
		<ul class="manageable" id="home-footer-widget">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Footer') ) : ?>
			<li></li>
		<?php endif; ?>
		</ul>
	<?php else: ?>
		<ul class="manageable" id="page-footer-widget">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Footer') ) : ?>
			<li></li>
		<?php endif; ?>
		</ul>
	<?php endif; ?>
</div>
<?php get_template_part('sidebar','right'); ?>
<?php get_footer(); ?>