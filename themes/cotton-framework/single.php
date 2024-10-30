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
	<?php if(is_front_page()): ?>
		<ul class="manageable" id="home-header-widget">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Header') ) : ?>
			<li></li>
		<?php endif; ?>
		</ul>
	<?php else: ?>
		<ul class="manageable" id="single-header-widget">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Single Header') ) : ?>
			<li></li>
		<?php endif; ?>
		</ul>
	<?php endif; ?>
	
	<?php get_template_part('loop', 'single'); ?>

	<?php if(is_front_page()): ?>
		<ul class="manageable" id="home-header-widget">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Header') ) : ?>
			<li></li>
		<?php endif; ?>
		</ul>
	<?php else: ?>
		<ul class="manageable" id="single-footer-widget">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Single Footer') ) : ?>
			<li></li>
		<?php endif; ?>
		</ul>
	<?php endif; ?>
</div>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>