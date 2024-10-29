<?php
/*
Plugin Name: Adf.ly page monetarization
Plugin URI: http://adf.ly/?id=3757920
Description: This plugin monetarizes your page with adf.ly
Version: 1.2
Author: Carl-Philip Hänsch
Author URI: http://launix.de
License: GPLv2
*/

add_option('adfly_id', '', null, 'yes');
add_option('adfly_advert', 'int', null, 'yes');

function adfly_entry() {
	$adfly_id = get_option('adfly_id');
	$adfly_advert = get_option('adfly_advert');
	// only insert code if adfly id is set
	if($adfly_id) {
?>
<script type="text/javascript">
    var adfly_id = <?php echo $adfly_id; ?>;
    var adfly_advert = '<?php echo $adfly_advert; ?>'; // int oder banner
    var frequency_cap = 5;
    var frequency_delay = 5;
    var init_delay = 3;
	var popunder = true;
</script>
<script src="https://cdn.adf.ly/js/entry.js"></script> 
<?php
	}
}

function int_or_banner($x) {
	// nur banner und int zulassen
	if($x == 'banner') return $x;
	return 'int';
}

function adfly_menu() {
	add_options_page( 'Adfly options', 'Adfly', 'edit_plugins', 'adflyi_settings_page', 'adfly_menu_fn' );
	add_action( 'admin_init', 'register_adfly_settings' );
}

function register_adfly_settings() {
	register_setting( 'adfly_options', 'adfly_id', 'intval' );
	register_setting( 'adfly_options', 'adfly_advert', 'int_or_banner' );
}

function adfly_menu_fn() {
?>
<div class="wrap">
<?php screen_icon(); ?>
<h2>Adfly Options</h2>
<form action="options.php" method="post">
<?php settings_fields( 'adfly_options' ); ?>
<?php do_settings_fields( 'adfly_options' ); ?>
<table class="form-table">
<tr align='top'>
<th scope='row'>Adfly ID (Example: 3757920)</th>
<td><input type='text' name='adfly_id' value='<?php echo esc_attr(get_option('adfly_id')); ?>' /></td></tr>
<tr align='top'>
<th scope='row'>Advertisement type</th>
<td><select name='adfly_advert'>
<option value='int'<?php if(get_option('adfly_advert') == 'int') echo " selected"; ?>>Page redirection</option>
<option value='banner'<?php if(get_option('adfly_advert') == 'banner') echo " selected"; ?>>Banner</option>
</select></td>
</tr>
</table>
<?php submit_button(); ?>
</form>
</div>
<?php
}

add_action( 'wp_print_scripts', 'adfly_entry' );
add_action( 'admin_menu', 'adfly_menu' );


