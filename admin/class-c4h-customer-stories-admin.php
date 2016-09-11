<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://teamzen.io
 * @since      1.0.0
 *
 * @package    C4h_Customer_Stories
 * @subpackage C4h_Customer_Stories/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    C4h_Customer_Stories
 * @subpackage C4h_Customer_Stories/admin
 * @author     Zenio <support@teamzen.io>
 */
class C4h_Customer_Stories_Admin extends C4h_Customer_Stories
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
//	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
//	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in C4h_Customer_Stories_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The C4h_Customer_Stories_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/c4h-customer-stories-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in C4h_Customer_Stories_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The C4h_Customer_Stories_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/c4h-customer-stories-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Register the Customer Stories post type
	 *
	 * @since   1.0.0
	 */
	public function register_cs_post_type(  ) {
		// Register our "customer-story" custom post type
		$labels = array(
			'name'               => _x( 'Customer Stories', 'c4h-customer-stories' ),
			'singular_name'      => _x( 'Customer Story', 'c4h-customer-stories' ),
			'add_new'            => _x( 'Add New', 'c4h-customer-stories' ),
			'add_new_item'       => _x( 'Add New Customer Story', 'c4h-customer-stories' ),
			'edit_item'          => _x( 'Edit Customer Story', 'c4h-customer-stories' ),
			'new_item'           => _x( 'New Customer Story', 'c4h-customer-stories' ),
			'view_item'          => _x( 'View Customer Story', 'c4h-customer-stories' ),
			'search_items'       => _x( 'Search Customer Stories', 'c4h-customer-stories' ),
			'not_found'          => _x( 'No Customer Stories found', 'c4h-customer-stories' ),
			'not_found_in_trash' => _x( 'No Customer Stories found in Trash', 'c4h-customer-stories' ),
			'menu_name'          => _x( 'Customer Stories', 'c4h-customer-stories' )
		);
		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'description'         => 'Create Customer Stories ',
			'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'excerpt' ),
			'taxonomies'          => array( '' ),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 23.424242,
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'show_in_rest'        => true,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post'
		);
		register_post_type( 'customer-story', $args );
	}

	/**
	 * Include the Custom Metabox 2 init.php file and call our metabox function.
	 *
	 * @since   1.0.0
	 */
	public function cs_include_cmb2(  ) {
		if ( file_exists( dirname( __FILE__ ) . '/partials/cmb2/init.php' ) ) {
			require_once dirname( __FILE__ ) . '/partials/cmb2/init.php';
		} elseif ( file_exists( dirname( __FILE__ ) . '/partials/CMB2/init.php' ) ) {
			require_once dirname( __FILE__ ) . '/partials/CMB2/init.php';
		} else {
			return;
		}

		add_action( 'cmb2_admin_init', array( $this, 'cs_meta_box' ) );

	}

	/**
	 * Setup the Meta box for the customer stories CPT
	 *
	 * @since   1.0.0
	 */
	public function cs_meta_box(  ) {
		$prefix = '_c4h_cs_';

		/**
		 * Sample metabox to demonstrate each field type included
		 */
		$cs_meta = new_cmb2_box( array(
			'id'            => $prefix . 'metabox',
			'title'         => esc_html__( 'Customer Story Information', 'c4h-customer-stories' ),
			'object_types'  => array( 'customer-story', ), // Post type
			// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
			 'context'    => 'normal',
			 'priority'   => 'high',
			// 'show_names' => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
			// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
			// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
		) );

		$cs_meta->add_field( array(
			'name'       => esc_html__( 'Story Title', 'cmb2' ),
			'desc'       => esc_html__( 'text to appear at the top of the story', 'c4h-customer-stories' ),
			'id'         => $prefix . 'story_title',
			'type'       => 'text',
		) );
		$cs_meta->add_field( array(
			'name'       => esc_html__( 'Location', 'cmb2' ),
			'desc'       => esc_html__( 'location to appear on the story', 'c4h-customer-stories' ),
			'id'         => $prefix . 'story_location',
			'type'       => 'text',
		) );

		$grid_group = $cs_meta->add_field( array(
			'id'           => $prefix . 'grid',
			'type'         => 'group',
			'before_group' => $this->cs_map_display( 'admin' ),
			'repeatable'  => false,
			'description'  => esc_html__( 'Determine the layout location of your story', 'c4h-customer-stories' ),
		) );

		$cs_meta->add_group_field( $grid_group, array(
			'name'             => esc_html__( 'Grid - row', 'c4h-customer-stories' ),
			'desc'             => esc_html__( 'Select the Grid row in which you want the story to appear', 'c4h-customer-stories' ),
			'id'               => 'grid_row_select',
			'type'             => 'select',
			'show_option_none' => true,
			'options_cb'       => 'C4h_Customer_Stories_Admin::cs_select_populate',
			'classes'          => 'cmb-row-half_column cmb-row-half_column_first',
		) );

		$cs_meta->add_group_field( $grid_group, array(
			'name'             => esc_html__( 'Grid - column', 'c4h-customer-stories' ),
			'desc'             => esc_html__( 'Select the Grid column in which you want the story to appear', 'c4h-customer-stories' ),
			'id'               => 'grid_column_select',
			'type'             => 'select',
			'show_option_none' => true,
			'options_cb'          => 'C4h_Customer_Stories_Admin::cs_select_populate',
			'classes'          => 'cmb-row-half_column cmb-row-half_column_first',
		) );
	}

	/**
	 * Generate options for grid selects
	 * @param  string $field      Current field name (row|column)
	 * @return array              Array of field options
	 * @since   1.0.0
	 */
	public static function cs_select_populate( $field ) {
		if ( esc_html__( 'Grid - column', 'c4h-customer-stories' ) === $field->args['name'] ){
			$max = 22;
		} else if ( esc_html__( 'Grid - row', 'c4h-customer-stories' ) === $field->args['name'] ) {
			$max = 18;
		} else {
			$max = 0;
		}
		$options = array();
		for ( $i = 0; $i < $max; $i++ ) {
			$options[ $i ] = $i;
		}
		return $options;
	}

}