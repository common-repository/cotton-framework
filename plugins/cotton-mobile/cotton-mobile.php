<?php
/**
 * Allows designers to change css by Window's Width
 *
 * Change the body id tag to 'handheld' if the Window Width is less than 960px, set to 'screen' otherwise.
 * Requires you to set your initial body id tag to 'handheld' to support mobile devices without JavaScript
 * Registers jQuery with WordPress and inserts inline javascript in to the wp_footer hook.
 *
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */

if( !is_admin() )
	new Cotton_Mobile;

class Cotton_Mobile {
	
	function Cotton_Mobile()
	{
		add_action('init',array(&$this,'init'));
		add_action('wp_footer',array(&$this,'wp_footer'));
		add_action( 'cotton_body_id', array( &$this, 'cotton_body_id' ) );
	} // function
	
	function init()
	{
		wp_enqueue_script('jquery'); 
	} // function
	
	function wp_footer()
	{
		?>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready(function(){
				width_handler();
			});
			
			var resizeTimer = null;
			jQuery(window).bind('resize', function() {
				if (resizeTimer) clearTimeout(resizeTimer);
				resizeTimer = setTimeout(width_handler, 100);
			});
			
			function width_handler() {
				jQuery("body").attr('id','');
				var width = jQuery("body").width();
				if(width <= 960) {
					jQuery("body").attr('id','handheld');
				} else {
					jQuery("body").attr('id','screen');
				}
			}
			//]]>
		</script>
		<?php
	} // function
	
	function cotton_body_id()
	{
		global $cotton_functions;
		if( 1 == $cotton_functions->get_option( 'cotton-mobile' ) ) { 
			echo "id='handheld'"; 
		} // if
	} // function
	
} // class

?>