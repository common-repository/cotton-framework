<?php 
/**
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
?>
			</div>
		</div>
		<div class="contents-child contents-footer">
			<div class="grid">
				<ul class="grid_20 manageable" id="site-content-footer-widget">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Content Footer') ) : ?>
						<li></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
	
	<div id="footer" class="contents">
		<div class="contents-child contents-header">
			<div class="grid">
				<ul class="grid_20 navigation manageable" id="site-footer-naigation-widget">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Navigation') ) : ?>
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Navigation') ) : ?>
							<li class="widget widget_pages">
								<ul>
									<li class="page_item home"><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('title'); ?>">Home</a></li>
									<?php wp_list_pages(array('title_li'=>'')); ?>
								</ul>
							</li>
						<?php endif; ?>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="contents-child contents-body">
			<div class="grid">
				<?php do_action( 'cotton_footer' ); ?>
			</div>
		</div>
		<div class="contents-child contents-footer">
			<div class="grid">
				<ul class="grid_20 manageable" id="site-footer-widget">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Site Footer') ) : ?>
						<li></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
	<?php flush(); ?>
	<div id="wp_footer">
	<?php wp_footer(); ?>
	</div>
</body>
</html>