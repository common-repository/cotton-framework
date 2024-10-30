<?php
/**
 * Registers libraries from Google AJAX Libraries API with WordPress
 *
 * Google AJAX Libraries API
 * @link http://code.google.com/apis/ajaxlibs/
 *
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */

if( !is_admin() )
	new Cotton_Register_Script;

class Cotton_Register_Script {
	
	function Cotton_Register_Script()
	{
		$this->settings = array(
			'jquery' => 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js',
			'jquery-ui-core' => 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js',
			'prototype' => 'http://ajax.googleapis.com/ajax/libs/prototype/1.6.1.0/prototype.js',
			'scriptaculous' => 'http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.3/scriptaculous.js',
			'moo-tools' => 'http://ajax.googleapis.com/ajax/libs/mootools/1.2.4/mootools-yui-compressed.js',
			'dojo' => 'http://ajax.googleapis.com/ajax/libs/dojo/1.4.1/dojo/dojo.xd.js',
			'swfobject' => 'http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js',
			'yui' => 'http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/yuiloader/yuiloader-min.js',
			'extcore' => 'http://ajax.googleapis.com/ajax/libs/ext-core/3.1.0/ext-core.js',
			'chrome-frame' => 'http://ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js',
			'webfont-loader' => 'http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js'
			);
		
		add_action('init', array(&$this,'init'));
	} // function
	
	function init()
	{
		foreach($this->settings as $slug => $url) {
			wp_deregister_script( $slug );
			wp_register_script($slug,$url);
		} // foreach
	} // function
	
} // class

?>