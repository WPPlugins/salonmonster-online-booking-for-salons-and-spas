<?php
/**
* Plugin Name: salonMonster Online Booking
* Plugin URI: http://salonmonster.com/
* Description: Easily add your salonMonster online booking to your salon or spa's Wordpress site
* Version: 1.0
* Author: salonMonster software
* Author URI: http://salonmonster.com
* License: GPL12
*/

add_action('admin_menu', 'salonMonsterMenu');

function salonMonsterMenu() {
	add_menu_page('salonMonster Online Booking', 'salonMonster', 'edit_pages', 'salonmonster-settings', 'salonMonsterSetttingsPage', 'dashicons-clock', 4);
}

add_action('admin_init', 'salonMonsterSettings');

function salonMonsterSettings(){
	register_setting('salonMonsterSettingsGroup', 'salonMonsterURL');
}

function salonMonsterSetttingsPage(){
?>

	<div class='wrap'>
		<h1>salonMonster Online Booking Settings</h1>
		<br />
		This plugin makes it easy to add your <a href='https://www.salonmonster.com'>salonMonster.com</a> online booking into your Wordpress site.<br /><br />

		<form method='post' action='options.php'>
			<?php settings_fields( 'salonMonsterSettingsGroup');?>
			<?php do_settings_sections('salonMonsterSettingsGroup');?>
				<h2>Please enter your salonMonster booking page address (URL):</h2>
				<input type='text' name='salonMonsterURL' size='50' value='<?php echo get_option('salonMonsterURL');?>' /><br />
				<span style='color:#999;'>eg.  https://yoursalon.salonmonster.com</span><br /><br />
				This can be found under: "Settings" > "Online Booking" in your salonMonster account.<br /><br />
<?php 
	if(strlen(get_option('salonMonsterURL'))>2){
?>
		<h2><span style='font-weight:normal'>To add online booking to any page simply use the shortcode:</span>  [salonmonster]</h2><br />
<?php
	}
?>
			<?php submit_button();?>
		</form>
		<br /><br />
	</div>
<?php
}

add_shortcode('salonmonster', 'salonMonsterShortcode');

function salonMonsterShortcode(){

	wp_register_script('iframeResizer', plugin_dir_url(__FILE__) . 'js/iframeResizer.min.js');
	wp_enqueue_script('iframeResizer' );

	wp_register_script('salonMonsterResizer', plugin_dir_url(__FILE__) . 'js/salonMonsterResizer.js', array('iframeResizer'));
	wp_enqueue_script('salonMonsterResizer' );

?>
	<style>
		iframe{
			width:100%;
		}
	</style>
	<iframe src="<?php echo get_option('salonMonsterURL'); ?>/client/index.php?layout=2" scrolling="no" frameborder="0"></iframe>
	<p id='callback'></p>
<?
}

?>