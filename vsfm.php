<?php
/**
 * Plugin Name: Very Simple Favicon Manager
 * Description: This is a very simple plugin to add an IOS site icon or a favicon in the address bar of your browser. For more info please check readme file.
 * Version: 1.9
 * Author: Guido van der Leest
 * Author URI: http://www.guidovanderleest.nl
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: very-simple-favicon-manager
 * Domain Path: translation
 */


// load the plugin's text domain
function vsfm_init() { 
	load_plugin_textdomain( 'very-simple-favicon-manager', false, dirname( plugin_basename( __FILE__ ) ) . '/translation' );
}
add_action('plugins_loaded', 'vsfm_init');
 

// add the admin options page
function vsfm_menu_page() {
	add_options_page( __( 'Favicon Manager', 'very-simple-favicon-manager' ), __( 'Favicon Manager', 'very-simple-favicon-manager' ), 'manage_options', 'vsfm', 'vsfm_options_page' );
}
add_action( 'admin_menu', 'vsfm_menu_page' );


// add the admin settings and such 
function vsfm_admin_init() {
	add_settings_section( 'vsfm-section', __( 'Favicon (16x16px or multi-size)', 'very-simple-favicon-manager' ), 'vsfm_section_callback', 'vsfm' );
	add_settings_field( 'vsfm-field', __( 'Your Favicon', 'very-simple-favicon-manager' ), 'vsfm_field_callback', 'vsfm', 'vsfm-section' );
	register_setting( 'vsfm-options', 'vsfm-setting', 'sanitize_text_field' );

	add_settings_section( 'vsfm-section-ios', __( 'IOS site icon (180x180px)', 'very-simple-favicon-manager' ), 'vsfm_section_callback_ios', 'vsfm' );
	add_settings_field( 'vsfm-field-ios', __( 'Your IOS site icon', 'very-simple-favicon-manager' ), 'vsfm_field_callback_ios', 'vsfm', 'vsfm-section-ios' );
	register_setting( 'vsfm-options', 'vsfm-setting-ios', 'sanitize_text_field' );
}
add_action( 'admin_init', 'vsfm_admin_init' );


function vsfm_section_callback() {
    echo __( 'Upload your favicon (.ico file) in the media library and copy-paste link here.', 'very-simple-favicon-manager' ); 
}

function vsfm_section_callback_ios() {
    echo __( 'Upload your icon (.png file) in the media library and copy-paste link here.', 'very-simple-favicon-manager' ); 
}


// add input fields
function vsfm_field_callback() {
	$vsfm_setting = esc_url( get_option( 'vsfm-setting' ) );
	echo "<input type='text' size='60' maxlength='150' name='vsfm-setting' value='$vsfm_setting' />";
}

function vsfm_field_callback_ios() {
	$vsfm_setting_ios = esc_url( get_option( 'vsfm-setting-ios' ) );
	echo "<input type='text' size='60' maxlength='150' name='vsfm-setting-ios' value='$vsfm_setting_ios' />";
}


// display the admin options page
function vsfm_options_page() {
?>
<div class="wrap"> 
	<div id="icon-plugins" class="icon32"></div> 
	<h1><?php _e( 'Very Simple Favicon Manager', 'very-simple-favicon-manager' ); ?></h1> 
	<hr>
	<form action="options.php" method="POST">
	<?php settings_fields( 'vsfm-options' ); ?>
	<?php do_settings_sections( 'vsfm' ); ?>
	<?php submit_button(__('Save', 'very-simple-favicon-manager')); ?>
	</form>
	<hr>
	<p><?php _e( 'When no favicon or site icon link is added, a default favicon or site icon will be used.', 'very-simple-favicon-manager' ); ?></p>
	<p><?php _e( 'For more info please check this page: ', 'very-simple-favicon-manager' ); ?><a href="https://wordpress.org/plugins/very-simple-favicon-manager/faq" target="_blank">VSFM FAQ</a></p>


</div>
<?php
}


// include favicon in header 
function vsfm_display_favicon() {
	$vsfm_custom_favicon = esc_url( get_option( 'vsfm-setting' ) );
	$vsfm_default_favicon = plugins_url( 'images/favicon.ico', __FILE__ ); 

	if (empty( $vsfm_custom_favicon )) {
		echo '<link rel="shortcut icon" href="'.$vsfm_default_favicon.'" />'."\n";
	}
	else {
		echo '<link rel="shortcut icon" href="'.$vsfm_custom_favicon.'" />'."\n";
	}
}
add_action( 'wp_head', 'vsfm_display_favicon' );


// include IOS site icon in header 
function vsfm_display_icon_ios() {
	$vsfm_custom_icon_ios = esc_url( get_option( 'vsfm-setting-ios' ) );
	$vsfm_default_icon_ios = plugins_url( 'images/apple-touch-icon.png', __FILE__ ); 

	if (empty( $vsfm_custom_icon_ios )) {
		echo '<link rel="apple-touch-icon" href="'.$vsfm_default_icon_ios.'" />'."\n";
	}
	else {
		echo '<link rel="apple-touch-icon" href="'.$vsfm_custom_icon_ios.'" />'."\n";
	}
}
add_action( 'wp_head', 'vsfm_display_icon_ios' );

?>