<?php
/*
  Plugin Name: WP Hotel Booking Block Room
  Plugin URI: http://thimpress.com/
  Description: Block booking rooms for specific dates
  Author: ThimPress
  Version: 1.7
  Author URI: http://thimpress.com
 */
// return;
define( 'TP_HB_BLOCK_DIR', plugin_dir_path( __FILE__ ) );
define( 'TP_HB_BLOCK_URI', plugin_dir_url( __FILE__ ) );
define( 'TP_HB_BLOCK_VER', '1.7' );

class WP_Hotel_Booking_Block {

	public $is_hotel_active = false;

	function __construct() {
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
	}

	/**
	 * load_textdomain
	 * @return null
	 */
	public function load_textdomain() {
		$default     = WP_LANG_DIR . '/plugins/wp-hotel-booking-block-' . get_locale() . '.mo';
		$plugin_file = TP_HB_BLOCK_DIR . '/languages/wp-hotel-booking-block-' . get_locale() . '.mo';
		$file        = false;
		if ( file_exists( $default ) ) {
			$file = $default;
		} else {
			$file = $plugin_file;
		}
		if ( $file ) {
			load_textdomain( 'wp-hotel-booking-block', $file );
		}
	}

	/**
	 * plugin loaded
	 * @return null
	 */
	function plugins_loaded() {
		if ( !function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		if ( ( class_exists( 'TP_Hotel_Booking' ) && is_plugin_active( 'tp-hotel-booking/tp-hotel-booking.php' ) ) || ( is_plugin_active( 'wp-hotel-booking/wp-hotel-booking.php' ) && class_exists( 'WP_Hotel_Booking' ) ) ) {
			$this->is_hotel_active = true;
		}

		if ( !$this->is_hotel_active ) {
			add_action( 'admin_notices', array( $this, 'add_notices' ) );
		} else {
			if ( $this->is_hotel_active && !class_exists( 'Hotel_Booking_Block' ) ) {
				require_once TP_HB_BLOCK_DIR . '/inc/functions.php';
				require_once TP_HB_BLOCK_DIR . '/inc/class-hb-block.php';
			}
		}
		/**
		 * text-domain
		 */
		$this->load_textdomain();
	}

	/**
	 * notice messages
	 */
	function add_notices() {
		?>
        <div class="error">
            <p><?php _e( 'The <strong>WP Hotel Booking</strong> is not installed and/or activated. Please install and/or activate before you can using <strong>WP Hotel Booking Block Room</strong> add-on.' ); ?></p>
        </div>
		<?php
	}

}

$hotel_block = new WP_Hotel_Booking_Block();
