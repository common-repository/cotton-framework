<?php 
/**
 * Left Sidebar Controller
 *
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */
global $sidebar_label,$sidebar_class;
$sidebar_label = 'Sidebar Left';
$sidebar_class = 'sidebar-left';
$file = '/sidebar.php';
if(file_exists(STYLESHEETPATH . $file)) {
	include( STYLESHEETPATH . $file ); 
} else {
	include( TEMPLATEPATH . $file);
}
?>