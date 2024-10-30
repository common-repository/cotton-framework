<?php
/**
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
?>
<form method="get" class="search-form" action="<?php bloginfo('url'); ?>/">
	<div>
	<input type="text" value="<?php the_search_query(); ?>" name="s" class="search-query"/>
	<input type="submit" class="search-submit" value="Search"/>
	</div>
</form>