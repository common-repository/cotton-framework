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
	<ul class="manageable" id="search-header-widget">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Search Header') ) : ?>
		<li></li>
	<?php endif; ?>
	</ul>
	
	<?php if( is_404() ): ?>
		<h2>Page Not Found</h2>
		<p>Perhaps a search would be a better use of your time?</p>
	<?php else: ?>
		<h2>Search Results for <?php the_search_query(); ?></h2>
	<?php endif; ?>
	
	<div class="search">
		<?php get_search_form(); ?>
	</div>
	<?php if( !is_404() ): ?>
		<?php if( have_posts() ) : ?>
			<?php get_template_part('loop', 'search'); ?>
		<?php else: ?>
			<p>No results for <?php the_search_query(); ?></p>
		<?php endif; ?>
	<?php endif; ?>

	<ul class="manageable" id="search-footer-widget">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Search Footer') ) : ?>
		<li></li>
	<?php endif; ?>
	</ul>
</div>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>