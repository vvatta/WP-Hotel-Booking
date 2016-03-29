<?php
/**
 * @Author: ducnvtt
 * @Date:   2016-03-24 16:36:36
 * @Last Modified by:   ducnvtt
 * @Last Modified time: 2016-03-25 09:38:52
 */

class HB_Admin_Metabox_Booking_Details {

	public $id = 'hb-booking-details';

	public $title = '';

	public $context = 'advanced';

	public $screen = 'hb_booking';

	public $priority = 'high';

	public $callback_args = null;

	function __construct() {

		$this->title = __( 'Booking Details', 'tp-hotel-booking' );

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ), 10, 2 );
		add_action( 'save_post', array( $this, 'update' ) );
	}

	public function add_meta_box( $post_type, $post ) {
		add_meta_box( $this->id, $this->title, array( $this, 'render' ), $this->screen, $this->context, $this->priority, $this->callback_args );
	}

	public function render() {
		require_once HB_PLUGIN_PATH . '/includes/admin/metaboxes/views/meta-booking-details.php';
	}

	public function update( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
	}

}