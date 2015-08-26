<?php
/**
 * Plugin Name: Very Simple Favicon Manager
 * Description: This is a very simple plugin to add an IOS, Android or Windows app icon or a favicon in the address bar of your browser. For more info please check readme file.
 * Version: 1.6
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
	add_settings_section( 'vsfm-section', __( 'Favicon (16x16px or 32x32px)', 'favicon' ), 'vsfm_section_callback', 'vsfm' );
	add_settings_field( 'vsfm-field', __( 'Your Favicon', 'favicon' ), 'vsfm_field_callback', 'vsfm', 'vsfm-section' );
	register_setting( 'vsfm-options', 'vsfm-setting', 'sanitize_text_field' );

	add_settings_section( 'vsfm-section-ios', __( 'IOS app icon (180x180px)', 'favicon' ), 'vsfm_section_callback_ios', 'vsfm' );
	add_settings_field( 'vsfm-field-ios', __( 'Your IOS app icon', 'favicon' ), 'vsfm_field_callback_ios', 'vsfm', 'vsfm-section-ios' );
	register_setting( 'vsfm-options', 'vsfm-setting-ios', 'sanitize_text_field' );

	add_settings_section( 'vsfm-section-android', __( 'Android app icon (192x192px)', 'favicon' ), 'vsfm_section_callback_android', 'vsfm' );
	add_settings_field( 'vsfm-field-android', __( 'Your Android app icon', 'favicon' ), 'vsfm_field_callback_android', 'vsfm', 'vsfm-section-android' );
	register_setting( 'vsfm-options', 'vsfm-setting-android', 'sanitize_text_field' );

	add_settings_section( 'vsfm-section-windows', __( 'Windows app icon (270x270px)', 'favicon' ), 'vsfm_section_callback_windows', 'vsfm' );
	add_settings_field( 'vsfm-field-windows', __( 'Your Windows app icon', 'favicon' ), 'vsfm_field_callback_windows', 'vsfm', 'vsfm-section-windows' );
	register_setting( 'vsfm-options', 'vsfm-setting-windows', 'sanitize_text_field' );
}
add_action( 'admin_init', 'vsfm_admin_init' );


function vsfm_section_callback() {
    echo __( 'Upload your favicon (.ico or .png file) in the media library and copy-paste link here.', 'favicon' ); 
}

function vsfm_section_callback_ios() {
    echo __( 'Upload your icon (.png file) in the media library and copy-paste link here.', 'favicon' ); 
}


function vsfm_section_callback_android() {
	echo __( 'Upload your icon (.png file) in the media library and copy-paste link here.', 'favicon' ); 
}

function vsfm_section_callback_windows() {
	echo __( 'Upload your icon (.png file) in the media library and copy-paste link here.', 'favicon' ); 
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

function vsfm_field_callback_android() {
	$vsfm_setting_android = esc_url( get_option( 'vsfm-setting-android' ) );
	echo "<input type='text' size='60' maxlength='150' name='vsfm-setting-android' value='$vsfm_setting_android' />";
}

function vsfm_field_callback_windows() {
	$vsfm_setting_windows = esc_url( get_option( 'vsfm-setting-windows' ) );
	echo "<input type='text' size='60' maxlength='150' name='vsfm-setting-windows' value='$vsfm_setting_windows' />";
}


// display the admin options page
function vsfm_options_page() {
?>
<div class="wrap"> 
	<div id="icon-plugins" class="icon32"></div> 
	<h1><?php _e( 'Very Simple Favicon Manager', 'favicon' ); ?></h1> 
<hr>
<h3>In next update I will remove the Windows app icon again, because Windows uses too many different sizes.</h3>
<h3>And because many Android devices use the same icon as IOS devices, I will combine the two in next update.</h3>
<h3>Next update first week of september so untill then you can clear the Android and Wndows input fields.<h3>
<hr>
	<form action="options.php" method="POST">
	<?php settings_fields( 'vsfm-options' ); ?>
	<?php do_settings_sections( 'vsfm' ); ?>
	<?php submit_button(__('Save', 'favicon')); ?>
	</form>
	<p><?php _e( 'When no favicon or app icon is added, a default favicon or app icon will be used.', 'favicon' ); ?></p>
</div>
<?php
}


// include favicon in header 
function vsfm_display_favicon() {
	$vsfm_custom_favicon = esc_url( get_option( 'vsfm-setting' ) );
	$vsfm_default_favicon = plugins_url( 'images/favicon.png', __FILE__ ); 

	if (empty($vsfm_custom_favicon)) {
		echo '<link rel="icon" href="'.$vsfm_default_favicon.'" />'."\n";
	}
	else {
		echo '<link rel="icon" href="'.$vsfm_custom_favicon.'" />'."\n";
	}
}
add_action( 'wp_head', 'vsfm_display_favicon' );


// include IOS app icon in header 
function vsfm_display_icon_ios() {
	$vsfm_custom_icon_ios = esc_url( get_option( 'vsfm-setting-ios' ) );
	$vsfm_default_icon_ios = plugins_url( 'images/icon-ios.png', __FILE__ ); 

	if (empty($vsfm_custom_icon_ios)) {
		echo '<link rel="apple-touch-icon" href="'.$vsfm_default_icon_ios.'" sizes="180x180" />'."\n";
	}
	else {
		echo '<link rel="apple-touch-icon" href="'.$vsfm_custom_icon_ios.'" sizes="180x180"/>'."\n";
	}
}
add_action( 'wp_head', 'vsfm_display_icon_ios' );


// include Android app icon in header 
function vsfm_display_icon_android() {
	$vsfm_custom_icon_android = esc_url( get_option( 'vsfm-setting-android' ) );
	$vsfm_default_icon_android = plugins_url( 'images/icon-android.png', __FILE__ ); 

	if (empty($vsfm_custom_icon_android)) {
		echo '<link rel="icon" href="'.$vsfm_default_icon_android.'" sizes="192x192" />'."\n";
	}
	else {
		echo '<link rel="icon" href="'.$vsfm_custom_icon_android.'" sizes="192x192" />'."\n";
	}
}
add_action( 'wp_head', 'vsfm_display_icon_android' );


// include Windows app icon in header 
function vsfm_display_icon_windows() {
	$vsfm_custom_icon_windows = esc_url( get_option( 'vsfm-setting-windows' ) );
	$vsfm_default_icon_windows = plugins_url( 'images/icon-windows.png', __FILE__ ); 

	if (empty($vsfm_custom_icon_windows)) {
		echo '<meta name="msapplication-TileImage" content="href="'.$vsfm_default_icon_windows.'">'."\n";
	}
	else {
		echo '<meta name="msapplication-TileImage" content="href="'.$vsfm_custom_icon_windows.'">'."\n";
	}
}
add_action( 'wp_head', 'vsfm_display_icon_windows' );

?>