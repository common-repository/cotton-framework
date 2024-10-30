<?php 
/**
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
global $post;
?>
<div id="posts">
	<?php 
		do_action( 'cotton_loop_start' );
		while(have_posts()): the_post(); 
			do_action( 'cotton_post_start' );
	?>
	<div <?php post_class(); ?>>	
		<h2 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<span class="post-info">
			<?php if( !is_page() ): ?>
				Posted on <?php the_time('F d, Y'); ?> by <?php the_author_posts_link(); ?> 
				<?php 
					if( is_attachment() ): 
					$parent_id = $post->post_parent;
					$parent_title = get_the_title( $parent_id );
					$parent_permalink = get_permalink( $parent_id );
				?>
					in <a href="<?php echo $parent_permalink; ?>" rel="bookmark" title="<?php echo $parent_title; ?>"><?php echo $parent_title; ?></a>
				<?php endif; ?>
			<?php endif; ?> <?php edit_post_link(); ?>
		</span>
		<div class="post-content">
			<?php 
				if( is_attachment() ) {
					if( wp_attachment_is_image() ):
						?>
						<p class="attachment">
							<?php echo wp_get_attachment_image( $post->ID, array( $content_width, $content_width ) ); ?>
						</p>
						
						<ul class="grid_20 navigation manageable">
							<li>
								<ul class="attachments-navigation">
									<li class="previous-attachment"><?php previous_image_link( false ); ?></li>
									<li class="next-attachment"><?php next_image_link( false ); ?></li>
								</ul>
							</li>
						</ul>
						<?php
					else:
						?>
						<a href="<?php echo wp_get_attachment_url(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
						<?php
					endif;
					
				} else if( !is_single() && has_excerpt() ) {
					the_excerpt();
				} else {
					the_content("Continue reading " . the_title('', '', false)); 
				} // if, else
			?>
			<?php wp_link_pages(); ?>
			<ul class="manageable">
				<?php if( !is_page() && !is_attachment() ): ?>
					<li class="post-categories">Posted in <?php the_category(', '); ?></li>
					<li class="post-categories">Tagged with <?php the_tags('',', ',''); ?></li>
				<?php endif; ?>
				<li class="post-comments-link"><?php comments_popup_link('Be the first to comment', '1 Comment', '% Comments', 'commentslink', ''); ?></li>
			</ul>
		</div>
		<?php if(is_single()): ?>
		<div class="post-comments">
			<?php comments_template(); ?>
		</div>
		<?php endif; ?>
	</div>

	<?php 
			do_action( 'cotton_post_stop' );
		endwhile; 
		do_action( 'cotton_loop_stop' );
	?>

	<?php if( ( is_front_page() || is_search() || is_archive() ) && $wp_query->max_num_pages > 1): ?>
		<div class="grid_20 page-navigation">
			<?php do_action('cotton_paginate_links'); ?>
		</div>
	<?php endif; ?>
</div>