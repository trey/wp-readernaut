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
	add_action('admin_menu', readernaut_menu);
	add_action('admin_init', register_readernaut);
}
add_action('init', register_readernaut_widget);
add_action('wp_head', readernaut_style_base);

function register_readernaut() {
	register_setting('readernaut_group', 'readernaut_username');
	register_setting('readernaut_group', 'readernaut_category');
}

function register_readernaut_widget() {
	register_sidebar_widget('Readernaut', 'readernaut_widget');
	register_widget_control('Readernaut', 'readernaut_widget_control');
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

function readernaut_widget_control() {
	$options = get_option('readernaut_widget_settings');
}

function readernaut_widget($args) {
	extract($args);
	$user = get_settings('readernaut_username');
	// $category = get_settings('');
	$category = 'wishlist';
	$books = file_get_contents('http://readernaut.com/api/v1/xml/' . $user . '/books/' . $category . '/');
	$sx = simplexml_load_string($books);
	?>
	<?php echo $before_widget; ?>
		<?php echo $before_title . 'Readernaut' . $after_title; ?>
		<h3>Currently Reading</h3>
		<ul>
		<?php foreach ($sx->reader_book as $book_object): ?>
			<?php $book = $book_object->book_edition; ?>
			<li><a href="<?php echo $book->permalink; ?>"><img src="<?php echo $book->covers->cover_small ?>" alt="<?php echo $book->title ?>" /></a></li>
		<?php endforeach ?>
		</ul>

	<?php echo $after_widget; ?>
	<?php
}

function readernaut_style_base() {
echo <<<EOT
<style type="text/css" media="screen">
	#readernaut * { margin: 0; padding: 0; }
	#readernaut h3 { margin: 0; padding: 0; font-size: 12px; }
	#readernaut ul li { list-style-type: none; display: inline; padding: 0 3px 3px 0; }
	ul #readernaut ul li:before { content: ""; }
	ul #readernaut ul { margin: 0; padding: 0; }
</style>
EOT;
}
?>
