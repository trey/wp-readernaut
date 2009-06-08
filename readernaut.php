<?php
/*
Plugin Name: Readernaut
Plugin URI: http://github.com/trey/wp-readernaut/
Description: Show your Readernaut books on your WordPress site.
Author: Trey Piepmeier
Version: 1.0
Author URI: http://treypiepmeier.com/
*/

if (is_admin()) {
	add_action('admin_menu', 'readernaut_menu');
	add_action('admin_init', 'register_readernaut');
}

function register_readernaut() {
	register_setting('readernaut_group', 'readernaut_username');
}

function readernaut_menu() {
	add_options_page('Readernaut Options', 'Readernaut', 8, __FILE__, 'readernaut_options');
}

function readernaut_options() {
	?>
	<div class="wrap">
		<h2>Readernaut</h2>
		<form method="post" action="options.php">
			<?php settings_fields('readernaut_group'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Readernaut Username'); ?></th>
					<td>
						<input type="text" name="readernaut_username" value="<?php echo get_option('readernaut_username'); ?>" />
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
			</p>
		</form>
	</div><!-- /wrap -->
	<?php
}
?>
