<?php
/**
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
global $wp_query;
$curauth = $wp_query->get_queried_object();
?>
<?php get_header(); ?>
<?php get_sidebar('left'); ?>
<div class="grid_10 not-sidebar">
	<ul class="manageable" id="author-header-widget">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Author Header') ) : ?>
	<?php endif; ?>
	</ul>
	<div class="about-author">
	   	<h2><?php echo $curauth->display_name; ?></h2>
		<ul class="author-info">
	        <li class="author-avatar grid_4"><?php echo get_avatar(get_the_author_id(), 64); ?></li>
			<?php if(!empty($curauth->user_email)): ?><li class="author-email">Email: <?php echo antispambot($curauth->user_email); ?></li><?php endif; ?>
			<?php if(!empty($curauth->user_url)): ?><li class="author-website">Website: <a href="<?php echo $curauth->user_url; ?>" title="Website of <?php echo $current_user->display_name ?>"><?php echo $curauth->user_url; ?></a></li><?php endif; ?>
			<?php if(!empty($curauth->aim)): ?><li class="author-aim">AIM: <?php echo $curauth->aim; ?></li><?php endif; ?>
			<?php if(!empty($curauth->yim)): ?><li class="author-yim">Yahoo! IM: <?php echo $curauth->yim; ?></li><?php endif; ?>
			<?php if(!empty($curauth->jabber)): ?><li class="author-jabber">Jabber / Google Talk: <?php echo $curauth->jabber; ?></li><?php endif; ?>
			<?php if(!empty($curauth->description)): ?><li class="author-description"><?php echo $curauth->description; ?></li><?php endif; ?>
		</ul>
    </div>
	<div class="author-posts">
		<h6>Posts by <?php echo $curauth->display_name; ?>:</h6>

		<ul>
		<!-- The Loop -->
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<li>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a>,
				<?php the_time('d M Y'); ?> in <?php the_category(', ');?>
			</li>

		<?php endwhile; else: ?>
			<li><p>No Posts by this Author</p></li>

		<?php endif; ?>
		<!-- End Loop -->

		</ul>
	</div>
	<ul class="manageable" id="author-footer-widget">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Author Footer') ) : ?>
	<?php endif; ?>
	</ul>		
</div>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>