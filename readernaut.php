<?php
/*
Plugin Name: Readernaut
Plugin URI: http://github.com/trey/wp-readernaut/
Description: Show your Readernaut books on your WordPress site.
Author: Trey Piepmeier
Version: 1.0
Author URI: http://treypiepmeier.com/
*/

add_action('admin_menu', 'rn_menu');

function rn_menu() {
	add_options_page('Readernaut Options', 'Readernaut', 8, __FILE__, 'rn_options');
}

function rn_options() {
	$opt_name = 'rn_username';
	$hidden_field_name = 'rn_submit_hidden';
	$data_field_name = 'rn_username';
	
	$opt_val = get_option($opt_name);
	
	if ($_POST[$hidden_field_name] == 'Y') {
		$opt_val = $_POST[$data_field_name];
		update_option($opt_name, $opt_val);
		?>
		<div class="updated">
			<p><strong><?php _e('Options saved.', 'rn_trans_domain'); ?></strong></p>
		</div><!-- /updated -->
		<?php
	}
	?>
	<div class="wrap">
		<h2><?php _e('Readernaut Options', 'rn_trans_domain'); ?></h2>
	
		<form action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
			<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

			<p>
				<?php _e('Readernaut Username:', 'rn_trans_domain'); ?>
				<input type="text" name="<?php echo $data_field_name ?>" value="<?php echo $opt_val; ?>" size="20" />
			</p>
			<p class="submit">
				<input type="submit" name="Submit" value="<?php _e('Update Options', 'rn_trans_domain'); ?>" />
			</p>

		</form>
	</div><!-- /wrap -->
	<?php
}
?>
