<?php
/**
 * Plugin Name: Very Simple Favicon Manager
 * Description: This is a very simple plugin to add a favicon in the address bar of your browser. For more info please check readme file.
 * Version: 1.2
 * Author: Guido van der Leest
 * Author URI: http://www.guidovanderleest.nl
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: favicon
 * Domain Path: translation
 */


// load the plugin's text domain
function vsfm_init() { 
	load_plugin_textdomain( 'favicon', false, dirname( plugin_basename( __FILE__ ) ) . '/translation' );
}
add_action('plugins_loaded', 'vsfm_init');
 

// add the admin options page
function vsfm_menu_page() {
    add_options_page( __( 'Favicon Manager', 'favicon' ), __( 'Favicon Manager', 'favicon' ), 'manage_options', 'vsfm', 'vsfm_options_page' );
}
add_action( 'admin_menu', 'vsfm_menu_page' );


// add the admin settings and such 
function vsfm_admin_init() {
    register_setting( 'vsfm-options', 'vsfm-setting', 'sanitize_text_field' );
    add_settings_section( 'vsfm-section', __( 'How it works', 'favicon' ), 'vsfm_section_callback', 'vsfm' );
    add_settings_field( 'vsfm-field', __( 'Your Favicon', 'favicon' ), 'vsfm_field_callback', 'vsfm', 'vsfm-section' );
}
add_action( 'admin_init', 'vsfm_admin_init' );


function vsfm_section_callback() {
    echo __( 'Upload your favicon (.ico file) in the media library and copy-paste link here.', 'favicon' ); 
}


function vsfm_field_callback() {
    $vsfm_setting = esc_url( get_option( 'vsfm-setting' ) );
    echo "<input type='text' size='60' maxlength='150' name='vsfm-setting' value='$vsfm_setting' />";
}


// display the admin options page
function vsfm_options_page() {
?>
<div class="wrap"> 
	<div id="icon-plugins" class="icon32"></div> 
	<h1><?php _e( 'Very Simple Favicon Manager', 'favicon' ); ?></h1> 
	<form action="options.php" method="POST">
	<?php settings_fields( 'vsfm-options' ); ?>
	<?php do_settings_sections( 'vsfm' ); ?>
	<?php submit_button(__('Save Favicon', 'favicon')); ?>
	</form>
	<p><?php _e( 'A favicon is a 16x16px or 32x32px icon with extension .ico which is displayed in the address bar of your browser and in your bookmark list.', 'favicon' ); ?></p>
	<p><?php _e( 'When no favicon is added, the default WordPress favicon will be used.', 'favicon' ); ?></p>
</div>
<?php
}


// include favicon in header 
function vsfm_display_icon() {
	$vsfm_custom_icon = esc_url( get_option( 'vsfm-setting' ) );
	$vsfm_default_icon = plugins_url( 'images/favicon.ico', __FILE__ ); 

	if (empty($vsfm_custom_icon)) {
		echo '<link rel="shortcut icon" href="'.$vsfm_default_icon.'" />'."\n";
	}
	else {
		echo '<link rel="shortcut icon" href="'.$vsfm_custom_icon.'" />'."\n";
	}
}
add_action( 'wp_head', 'vsfm_display_icon' );
?>