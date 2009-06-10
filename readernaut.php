<?php
/*
Plugin Name: Readernaut
Plugin URI: http://github.com/trey/wp-readernaut/
Description: Show the world your Readernaut books.
Author: Trey Piepmeier
Version: 1.0
Author URI: http://treypiepmeier.com/
*/

add_action('widgets_init', readernaut_load_widgets);

function readernaut_load_widgets() {
	register_widget('Readernaut_Widget');
}

class Readernaut_Widget extends WP_Widget {
	function Readernaut_Widget() {
		$widget_ops = array('classname' => 'readernaut', 'description' => 'Display your Readernaut books');
		$control_ops = array('id_base' => 'readernaut-widget');
		$this->WP_Widget('readernaut-widget', 'Readernaut', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance) {
		extract($args);
		$user = $instance['user'];
		$category = $instance['category'];
		$title = 'Readernaut: ' . ucwords($category);
		
		echo $before_widget;
		echo $before_title . '<h2>' . $title . '</h2>' . $after_title;

		$books_xml = file_get_contents('http://readernaut.com/api/v1/xml/' . $user . '/books/' . $category . '/');
		$books = simplexml_load_string($books_xml);

		?>
		<ul>
		<?php foreach ($books->reader_book as $book_object): ?>
			<?php $book = $book_object->book_edition; ?>
			<li><a href="<?php echo $book->permalink; ?>"><img src="<?php echo $book->covers->cover_small ?>" alt="<?php echo $book->title ?>" /></a></li>
		<?php endforeach ?>
		</ul>
		<?php

		echo $after_widget;
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		
		$instance['user'] = strip_tags($new_instance['user']);
		$instance['category'] = $new_instance['category'];
		
		return $instance;
	}
	
	function form($instance) {
		$defaults = array('user' => 'trey', 'category' => 'reading');
		$instance = wp_parse_args((array) $instance, $defaults);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('user'); ?>">Readernaut Username:</label>
			<input id="<?php echo $this->get_field_id('user'); ?>" name="<?php echo $this->get_field_name('user'); ?>" value="<?php echo $instance['user']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>">Category:</label>
			<select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat">
				<option value="reading" <?php if('reading' == $instance['category']) echo 'selected="selected"'; ?>>Reading</option>
				<option value="wishlist" <?php if('wishlist' == $instance['category']) echo 'selected="selected"'; ?>>Wishtlist</option>
				<option value="finished" <?php if('finished' == $instance['category']) echo 'selected="selected"'; ?>>Finished</option>
				<option value="plan-to-read" <?php if('plan-to-read' == $instance['category']) echo 'selected="selected"'; ?>>Plan to read</option>
				<option value="reference" <?php if('reference' == $instance['category']) echo 'selected="selected"'; ?>>Reference</option>
				<option value="abandoned" <?php if('abandoned' == $instance['category']) echo 'selected="selected"'; ?>>Abandoned</option>
				<option value="all" <?php if('all' == $instance['category']) echo 'selected="selected"'; ?>>All</option>
			</select>
		</p>
		<?php
	}
}

?>
