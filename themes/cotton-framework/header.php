<?php 
/**
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title('-',true,'right'); ?><?php bloginfo('title'); ?></title>
<meta name="generator" content="Cotton Framework" />
<meta name="viewport" content="width = device-width" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/images/favicon.ico" />
<?php wp_head(); ?>
</head>
<?php flush(); ?>
<body <?php do_action('cotton_body_id'); ?> <?php body_class(); ?>>
	
	<div id="header" class="contents">
		<div class="contents-child contents-header">
			<div class="grid">
				<ul class="grid_20 manageable" id="site-header-widget">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Site Header') ) : ?>
						<li></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="contents-child contents-body">
			<div class="grid">
				<div class="grid_20">
					<?php do_action( 'cotton_header' ); ?>
				</div>
			</div>
		</div>
		<div class="contents-child contents-footer">
			<div class="grid">
				<ul class="grid_20 navigation manageable" id="site-header-navigation-widget">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Header Navigation') ) : ?>
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
	</div>
	
	<div id="body" class="contents">
		<div class="contents-child contents-header">
			<div class="grid">
				<ul class="grid_20 manageable" id="site-content-header-widget">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Content Header') ) : ?>
						<li></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
		<div class="contents-child contents-body">
			<div class="grid">