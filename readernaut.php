<?php
/*
Plugin Name: Readernaut
Plugin URI: http://github.com/trey/wp-readernaut/
Description: Show your Readernaut books on your WordPress site.
Author: Trey Piepmeier
Version: 1.0
Author URI: http://treypiepmeier.com/
*/

add_action('admin_menu', 'readernaut_menu');

function readernaut_menu() {
	add_options_page('Readernaut Options', 'Readernaut', 8, __FILE__, 'readernaut_options');
}

function readernaut_options() {
	?>
	<div class="wrap">
		<h2>Readernaut</h2>
		<form method="post" action="options.php">
			<?php wp_nonce_field('update-options'); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php _e('Readernaut Username'); ?></th>
					<td>
						<input type="text" name="readernaut_username" value="<?php echo get_option('readernaut_username'); ?>" />
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="page_options" value="readernaut_username" />
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
