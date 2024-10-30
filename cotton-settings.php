<?php
/**
 * Handles WordPress Settings API
 *
 * Manages the Settings page including Optional Plugins
 * 
 * @package Cotton Framework
 * @link http://code.google.com/p/cotton-framework/
 *
 * @since 0.1
 */

class Cotton_Settings {
	
	function Cotton_Settings()
	{
		$this->settings_section = 'cotton-framework';
		$this->plugins_section = $this->settings_section . '-plugins';
		$this->settings_defaults = array(
			'expose-authors' => 0,
			'advanced-widgets' => 0,
			'sidebar-layout' => 'sidebar-r',
			'frontpage-post-category' => 'default',
			'google-analytics-id' => '',
			'google-site-verification' => '',
			'doctype' => 'xhtml1-transitional',
			'cotton-robots' => 1,
			'cotton-sitemap' => 1,
			'cotton-mobile' => 1,
			'cotton-register-script' => 1
			);
		$this->settings_values = get_option( $this->settings_section );
		
		$this->plugins = array(
			'cotton-robots' => array(
				'title' => "Robots Generator",
				'description' => "Search Engine Optimization - Improve framework for search engines with a robots file.<br/><strong>Requires a custom <a href='options-permalink.php' title='Change your permalink structure'>permalink</a> structure.</strong> <small>Visit <a href='http://www.robotstxt.org/' target='_blank'>robotstxt.org</a> for more information on the Robots file.</small>"
				),
			'cotton-sitemap' => array(
				'title' => "Sitemap Generator",
				'description' => "Search Engine Optimization - Improve framework for search engines with a sitemap file.<br/><strong>Requires a custom <a href='options-permalink.php' title='Change your permalink structure'>permalink</a> structure.</strong> <small>Visit <a href='http://www.sitemaps.org/' target='_blank'>sitemaps.org</a> for more information on the Sitemaps file.</small>"
				),
			'cotton-mobile' => array(
				'title' => "Mobile Support",
				'description' => "Web Site Optimization - Enable support for Mobile Browsers."
				),
			'cotton-register-script' => array(
				'title' => "Google Hosted AJAX Libraries",
				'description' => "Web Site Optimization - Register Google's hosted AJAX Libraries with WordPress."
				)
			);
			
		foreach($this->plugins as $plugin => $info) {
			if( 1 == $this->settings_values[$plugin] && file_exists( COTTON_PLUGIN_DIR . '/' . $plugin . '/' . $plugin . '.php' ) )
				include_once( COTTON_PLUGIN_DIR . '/' . $plugin . '/' . $plugin . '.php');
		} // foreach
		
		add_action( 'admin_init', array(&$this, 'admin_init') );
		add_action( 'admin_menu', array(&$this, 'admin_menu') );
		add_action( 'plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2 );
	} // function
	
	function admin_menu()
	{
		add_submenu_page( 'options-general.php', 'Cotton Framework', 'Cotton Framework', 'administrator', $this->settings_section, array(&$this,'submenu_page'));
	} // function
	
	function admin_init()
	{
		$this->settings_values = get_option( $this->settings_section );
		
		/**
		 * Framework Options
		 */
		add_settings_section( $this->settings_section, 'Cotton Framework', array(&$this, 'settings_section'), $this->settings_section);
				
		# Front Page Posts
		add_settings_field( $this->settings_section . "['frontpage-post-category']", 'Front Page Post Category', array(&$this, 'setting_frontpage_post_category'), $this->settings_section, $this->settings_section );
		
		# Sidebar Layout
		add_settings_field( $this->settings_section . "['sidebar-layout']", 'Sidebar Layout', array(&$this, 'setting_sidebar_layout'), $this->settings_section, $this->settings_section );
		
		# Advanced Widgets
		add_settings_field( $this->settings_section . "['advanced-widgets']", 'Advanced Sidebars', array(&$this, 'setting_advanced_widgets'), $this->settings_section, $this->settings_section );
		
		# Expose Author Links
		add_settings_field( $this->settings_section . "['expose-authors']", 'Display Links to Authors', array(&$this, 'setting_expose_authors'), $this->settings_section, $this->settings_section );
		
		# Google Analytics ID
		add_settings_field( $this->settings_section . "['google-analytics-id']", 'Google Web Property ID', array(&$this, 'setting_google_analytics_id'), $this->settings_section, $this->settings_section );
		
		# Google Site Verification
		add_settings_field( $this->settings_section . "['google-site-verification']", 'Google Site Verification', array(&$this, 'setting_google_site_verification'), $this->settings_section, $this->settings_section );
		
		# Bing Site Verification
		add_settings_field( $this->settings_section . "['bing-site-verification']", 'Bing Site Verification', array(&$this, 'setting_bing_site_verification'), $this->settings_section, $this->settings_section );
		
		/**
		 * Plugin Options
		 */
		add_settings_section( $this->plugins_section, 'Cotton Framework Plugins', array(&$this, 'plugins_section'), $this->settings_section);
		
		foreach($this->plugins as $plugin => $info) {
			$info['id'] = $plugin;
			add_settings_field( $this->settings_section . "['$plugin']", $info['title'], array(&$this, 'plugin_checkbox'), $this->settings_section, $this->plugins_section, $info );
		} // foreach
		
	} // function
	
	function plugin_action_links($links, $file)
	{
		if( basename($file) == $this->settings_section .'.php' ) {
			$settings_link = '<a href="options-general.php?page='.$this->settings_section.'">Settings</a>';
			array_unshift($links, $settings_link);
		} // if
		
		return $links;
	} // function
	
	function plugins_section()
	{
		echo "<p>Enable or disable Cotton's built-in Plugins.</p>";
	} // function
	
	function plugin_checkbox( $info = '' )
	{
		$setting_id = $info['id'];
		$setting_field = $this->settings_section . "[$setting_id]";
		$setting_default = $this->settings_defaults[$setting_id];
		$setting_value = $this->settings_values[$setting_id];
		
		echo "<input type='hidden' name='$setting_field' value='0'/>";
		$checked = checked( $setting_value, '1', false );
		echo "<input type='checkbox' name='$setting_field' value='1' $checked> " . $info['description'];
	} // function
	
	function settings_section()
	{
		echo "<p>Control Cotton's functionality.</p>";
	} // function
	
	function submenu_page()
	{
		?>
		<div class="wrap">
		<div id="icon-themes" class="icon32"><br></div>
		<h2>Cotton Framework Settings</h2>
		<ul>
			<li><a href="http://code.google.com/p/cotton-framework/" title="Cotton Framework on Google Code" target="_blank">Leave feedback and feature requests.</a></li>
			<li><a href="mailto:w3prodigy@gmail.com" title="Send a url to your site">Have a cool site using the framework? Show us your site so we can see how the framework is being used.</a></li>
		</ul>
		<?php
			if ( !empty( $_POST['action'] ) && 'update' == $_POST['action'] ) {
				update_option( $this->settings_section, $_POST[$this->settings_section] );
				$this->settings_values = get_option( $this->settings_section );
				echo '<div id="message" class="updated fade"><p><strong>'.__('Options saved.').'</strong></p></div>';
			} // if
		?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
			<?php settings_fields( $this->settings_section ); ?>
			<?php do_settings_sections( $this->settings_section ); ?>
			<p class="submit">
			<input type="submit" class="button-primary" value="Save Changes" />
			</p>
		</form>
		<?php
	} // function
	
	function settings_plugin( $plugin_id, $plugin_label )
	{
		
	} // function
	
	function setting_frontpage_post_category()
	{	
		/**
		 * Define Setting
		 */
		$setting_id = 'frontpage-post-category';
		$setting_field = $this->settings_section . "[$setting_id]";
		$setting_default = $this->settings_defaults[$setting_id];
		$setting_value = $this->settings_values[$setting_id];
		
		echo "<select name='{$this->settings_section}[$setting_id]'>";
		$selected = selected( $setting_value, $setting_default, false );
		echo "<option value='default' $selected>All Categories</option>";
		
		$categories = get_categories( array( 'echo' => 0 ) ); 
		foreach ($categories as $cat) {
			$selected = selected( $setting_value, $cat->term_id, false );
			$option = "<option value='{$cat->term_id}' $selected>{$cat->cat_name}</option>";
			echo $option;
		} // foreach
		
		echo "</select>";
	} // function
	
	function setting_sidebar_layout()
	{
		/**
		 * Define Setting
		 */
		$setting_id = 'sidebar-layout';
		$setting_field = $this->settings_section . "[$setting_id]";
		$setting_default = $this->settings_defaults[$setting_id];
		$setting_value = $this->settings_values[$setting_id];
		
		echo "<select name='{$this->settings_section}[$setting_id]'>";
		
		$options = array(
			'sidebar-n' => "No Sidebar",
			'sidebar-l' => "Left Sidebar Only",
			'sidebar-r' => "Right Sidebar Only",
			'sidebar-l-r' => "Left and Right Sidebars"
			);
		
		foreach($options as $key => $label) {
			$selected = selected( $setting_value, $key, false );
			echo "<option value='$key' $selected>$label</option>";
		} // foreach
		
		echo "</select>";
	} // function
	
	function setting_advanced_widgets()
	{
		$setting_id = 'advanced-widgets';
		$setting_field = $this->settings_section . "[$setting_id]";
		$setting_default = $this->settings_defaults[$setting_id];
		$setting_value = $this->settings_values[$setting_id];
		
		echo "<input type='hidden' name='$setting_field' value='0'/>";
		$checked = checked( $setting_value, '1', false );
		echo "<input type='checkbox' name='$setting_field' value='1' $checked> Enabled Advanced Sidebar Areas";
	} // function
	
	function setting_expose_authors()
	{
		$setting_id = 'expose-authors';
		$setting_field = $this->settings_section . "[$setting_id]";
		$setting_default = $this->settings_defaults[$setting_id];
		$setting_value = $this->settings_values[$setting_id];
		
		echo "<input type='hidden' name='$setting_field' value='0'/>";
		$checked = checked( $setting_value, '1', false );
		echo "<input type='checkbox' name='$setting_field' value='1' $checked> Display links to Author pages";
	} // function
	
	function setting_google_analytics_id()
	{
		$setting_id = 'google-analytics-id';
		$setting_field = $this->settings_section . "[$setting_id]";
		$setting_default = $this->settings_defaults[$setting_id];
		$setting_value = $this->settings_values[$setting_id];
		
		echo "<input type='text' size='24' maxlength='13' name='$setting_field' value='$setting_value' />";
		echo "<br/><small>Visit <a href='http://google.com/analytics' title='Google Analytics' target='_blank'>Google Analytics</a> to create your web property identification number.</small>";
	} // function
	
	function setting_google_site_verification()
	{
		$setting_id = 'google-site-verification';
		$setting_field = $this->settings_section . "[$setting_id]";
		$setting_default = $this->settings_defaults[$setting_id];
		$setting_value = $this->settings_values[$setting_id];
		
		echo "<input type='text' size='70' name='$setting_field' value='$setting_value' />";
		echo "<br/><small>Visit <a href='http://www.google.com/webmasters/' title='Google Web Master Central' target='_blank'>Google Web Master Central</a> to create your site verification number.</small>";
	} // function
	
	function setting_bing_site_verification()
	{
		$setting_id = 'bing-site-verification';
		$setting_field = $this->settings_section . "[$setting_id]";
		$setting_default = $this->settings_defaults[$setting_id];
		$setting_value = $this->settings_values[$setting_id];
		
		echo "<input type='text' size='70' name='$setting_field' value='$setting_value' />";
		echo "<br/><small>Visit <a href='http://www.bing.com/webmaster/' title='Bing Web Master Tools' target='_blank'>Bing Web Master Tools</a> to create your site verification number.</small>";
	} // function
	
} // class

?>