<?php
/**
 * ... Widget plugin.
 *
 * Adds a new widget which outputs ...
 *
 * @category  ...Widget
 * @package  Widget
 * @author   Gary Jones
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 or later
 *
 * @wordpress
 * Plugin Name: ... Widget
 * Plugin URI: http://gamajo.com/
 * Description: Adds a new widget which outputs ...
 * Version: 1.0.0
 * Author: Gary Jones
 * Author URI: http://gamajo.com/
 * License: GPL v2.0 or later
 */

add_action( 'widgets_init', create_function( '', "register_widget( 'My_Widget' );" ) );

/**
 * ... Widget class.
 *
 * @package Widget
 * @author Gary Jones
 * @todo Rename My_Widget.
 */
class My_Widget extends WP_Widget {

	/**
	 * The plugin version, used as the version for dependencies.
	 *
	 * @since 1.0.0
	 */
	const version = '1.0.0';

	/**
	 * The text domain for localization.
	 *
	 * @since 1.0.0
	 */
	const domain = 'my-widget';

	/**
	 * Sets up the widget initilisation.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		if( ! load_plugin_textdomain( self::domain, false, '/wp-content/languages/' ) )
			load_plugin_textdomain( self::domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		$widget_options = array(
			'classname'   => 'widget-my-widget', // Class name of front-end of widget
			'description' => __( '...', self::domain ), // Description of widget on Widgets screen
		);
		$control_options = array(
			//'id_base' => 'my-widget', // Base ID for the widget form, default is Base ID from below
			//'width'   => 250, // Widget form width, required only if > 250px
		);
		parent::__construct(
				'my-widget',  // Base ID for the front-end of the widget, has to be unique
				__( 'My Widget', self::domain ), // Name of widget displayed on Widgets screen
				$widget_options,
				$control_options
		);

		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'dependencies' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'dependencies' ) );

	}

	/**
	 * Output widget content to front-end.
	 *
	 * @since 1.0.0
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args
	 * @param array $instance
	 * @return null Returns null if no category IDs are given.
	 */
	public function widget( $args, $instance ) {

		extract( $args );

		// Defaults
		$instance = wp_parse_args( (array) $instance, array(
			'title'       => '',  // Widget title
			'include_css' => '',  // Include CSS reference
		) );

		// Open widget markup
		echo $before_widget;

		// Echo title if given
		if ( ! empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title', $instance['title'] ) . $after_title;

		// Retrieve widget values

		include plugin_dir_path( __FILE__ ) . 'views/widget.php';

		echo $after_widget;

	}

	/**
	 * Validate the input values as they are updated.
	 *
	 * @since 1.0.0
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance The submitted values
	 * @param type $old_instance The previously saved values
	 * @return array The validated submitted values
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title']       = strip_tags( $new_instance['title'] );
		$instance['include_css'] = $new_instance['include_css'] ? 1 : 0;

		return $instance;

	}

	/**
	 * Display widget options.
	 *
	 * @since 1.0.0
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values
	 */
	public function form( $instance ) {

		// Ensure value exists
		$instance = wp_parse_args( (array) $instance, array(
			'title'       => '',
			'include_css' => '',
		) );

		include plugin_dir_path( __FILE__ ) . 'views/admin.php';


	}

	/**
	 * Register style and scripts for front-end and back-end.
	 *
	 * If WP_DEBUG is defined as true, then references are made to the
	 * un-minified (development) versions, rather than the minified production
	 * versions of the files.
	 *
	 * @since 1.0.0
	 */
	public function dependencies() {

		global $current_screen;

		// If debugging, reference unminified files, with a constantly fresh cache buster.
		$suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '.dev' : '';
		$version = ( defined ( 'WP_DEBUG' ) && WP_DEBUG ) ? time() : self::version;

		if( is_admin() && 'widgets' == $current_screen->id ) {
			wp_enqueue_script( __CLASS__,  plugins_url( 'js/admin' . $suffix . '.js', __FILE__ ), array( 'jquery' ), $version, true );
			wp_enqueue_style(__CLASS__, plugins_url( 'css/admin' . $suffix . '.css', __FILE__ ), false, $version );
		} elseif ( ! is_admin() && is_active_widget( false, false, $this->id_base ) ) {
			wp_enqueue_script( __CLASS__,  plugins_url( 'js/widget' . $suffix . '.js', __FILE__ ), array( 'jquery' ), $version, true );
			wp_enqueue_style(__CLASS__, plugins_url( 'css/widget' . $suffix . '.css', __FILE__ ), false, $version );
		}

	}

}