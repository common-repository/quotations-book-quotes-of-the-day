<?php
/*  Copyright 2013 QuotationsBook.com 

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
/*
Plugin Name: QuotationsBook widget
Plugin URI: http://quotationsbook.com/services/
Description: Show a quote of the day in your site's sidebar. To install, click activate and then go to Appearance > Widgets and look for the 'QuotationsBook Widget'. Next, drag the widget to your sidebar.
Version: 1.0
Author: QuotationsBook
Author URI: http://quotationsbook.com
*/

/**
 * Adds QB_Widget widget.
 */
class QB_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			__('QB Widget', 'text_domain'), // Name
			array( 'description' => __( 'Display a quote of the day in your blog!', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$qtype = apply_filters( 'widget_title', $instance['qtype'] );

                $title_hash = array(
                     "quoteoftheday" => "Quote of the Day"
                 );

		echo $args['before_widget'];
		if ( ! empty( $qtype) )
			echo $args['before_title'] . $title_hash[$qtype]. $args['after_title'];

		echo __( '<script type="text/javascript" src="http://quotationsbook.com/' . $qtype. '-js"></script><small><i><a href="http://quotationsbook.com/services/" target="_blank">more Quotes</a></i></small>', 'text_domain' );
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'qtype' ] ) ) {
			$qtype = $instance[ 'qtype' ];
		}
		else {
			$qtype = "quoteoftheday";
		}
		?>
	         <p>
			<label for="<?php echo $this->get_field_id( 'qtype' ); ?>">What type of quotes would you like?</label> 
			<select id="<?php echo $this->get_field_id( 'qtype' ); ?>" name="<?php echo $this->get_field_name( 'qtype' ); ?>" class="widefat" style="width:100%;">
				<option value="quoteoftheday" <?php if ( 'quoteoftheday' == $qtype ) echo 'selected="selected"'; ?>>Quote of the Day</option>							
			</select>
		</p>
		<?php 
	}

	/**
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['qtype'] = ( ! empty( $new_instance['qtype'] ) ) ? strip_tags( $new_instance['qtype'] ) : '';

		return $instance;
	}

} // class QB_Widget

// register QB_Widget widget
function register_foo_widget() {
    register_widget( 'QB_Widget' );
}
add_action( 'widgets_init', 'register_foo_widget' );
?>
