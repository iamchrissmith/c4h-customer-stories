<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://teamzen.io
 * @since      1.0.0
 *
 * @package    C4h_Customer_Stories
 * @subpackage C4h_Customer_Stories/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    C4h_Customer_Stories
 * @subpackage C4h_Customer_Stories/includes
 * @author     Zenio <support@teamzen.io>
 */
class C4h_Customer_Stories {
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      C4h_Customer_Stories_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;
    
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;
    
    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;
    
    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        
        $this->plugin_name = 'c4h-customer-stories';
        $this->version = '1.0.0';
        
        $this->_load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        
    }
    
    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - C4h_Customer_Stories_Loader. Orchestrates the hooks of the plugin.
     * - C4h_Customer_Stories_i18n. Defines internationalization functionality.
     * - C4h_Customer_Stories_Admin. Defines all hooks for the admin area.
     * - C4h_Customer_Stories_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function _load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-c4h-customer-stories-loader.php';
        
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-c4h-customer-stories-i18n.php';
        
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-c4h-customer-stories-admin.php';
        
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-c4h-customer-stories-public.php';
        
        $this->loader = new C4h_Customer_Stories_Loader();
        
    }
    
    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the C4h_Customer_Stories_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {
        
        $plugin_i18n = new C4h_Customer_Stories_i18n();
        
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
        
    }
    
    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        
        $plugin_admin = new C4h_Customer_Stories_Admin( $this->get_plugin_name(), $this->get_version() );
        
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'init', $plugin_admin, 'register_cs_post_type' );
        $this->loader->add_action( 'init', $plugin_admin, 'cs_include_cmb2' );
        
        
    }
    
    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        
        $plugin_public = new C4h_Customer_Stories_Public( $this->get_plugin_name(), $this->get_version() );
        
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	    $this->loader->add_action( 'init', $plugin_public, 'include_shortcode' );
	    
	    
        
    }
    
    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }
    
    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }
    
    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    C4h_Customer_Stories_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }
    
    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
	
	/**
	 *
	 * Runs WP_Query to get our published stories
	 *
	 * @return WP_Query $stories
	 */
	public static function get_stories() {
    	$args = array(
    	    'post_type' => 'customer-story',
		    'posts_per_page' => -1,
	        'post_status'     => 'publish',
	    );
	    
	    $stories = new WP_Query( $args );
	    wp_reset_postdata();
		$post_count = 0;
		if ( $stories->have_posts() ) : while ( $stories->have_posts() ) : $stories->the_post();
			
			$story_id = get_the_ID();
			$story_meta = get_post_meta( $story_id );
			
			$stories->posts[$post_count]->meta = $story_meta;
		
			$post_count++;
			
		endwhile; endif;
	
	    return $stories;
    }
	
	/**
	 * Display the map
	 *
	 * @param   $view   string  'admin' or 'public'
	 * @param   $stories    WP_Query    containing our Stories and their meta
	 * @param   $inactive   Array   [Optional] contains inactive grid items
	 *
	 * @return  $map_display    string  html to display map
	 * @since   1.0.0
	 */
	public function cs_get_map_display( $view, $stories, $inactive = array() ) {

		if ( 'admin' === $view ) {
			$map_display = '<div id="customer-stories" class="cs-map cs-admin-map"';
		} else {
			$map_display = '<div id="customer-stories" class="cs-map cs-public-map"';
		}
		$map_display .= 'style="background-image: url(\'' .plugin_dir_url( dirname(__FILE__) ) . 'img/map.png\')" >';
		
		$count = 1;
		while ($count <= (22*18)) {
			$map_display .= '<div id="cs-map-item-'.$count.'" data-cs_location ="'.$count.'" class="cs-map-item';
			//todo: add current item indicator
			
			if ( 'admin' === $view ) {
				if ( is_array( $inactive['occupied'] ) && in_array( $count, $inactive['occupied'] ) ) {
					$map_display .= ' cs-map-item__occupied';
				} else if ( is_array( $inactive['neighbors'] ) && in_array( $count, $inactive['neighbors'] ) ) {
					$map_display .= ' cs-map-item__inactive';
				}
			}
			
			
			$map_display .= '" >';
			
			//Add Column and Row count for admin display
			if ( 'admin' !== $view ) {
//				if ( $count <= 22 ) {
//					$map_display .= '<span class="cs-admin-grid">' . $count . '</span>';
//				} else if ( 1 === $count % 22 ) {
//					$row = (int)($count / 22);
//					$map_display .= '<span class="cs-admin-grid">' . ++$row . '</span>';
//				}
//			} else {
				if ( $stories->have_posts() ) : while ( $stories->have_posts() ) : $stories->the_post();
					$story = get_post();
					$location = (int) $story->meta['_c4h_cs_grid_number'][0];
					$slug = $story->post_name;
					if ($count === $location ) {
						$map_display .= '<a class="cs-map-thumbnail" id=cs-map-item-'.$slug.'" href="#'.$slug.'">';
						if ( has_post_thumbnail() ) {
							$map_display .= get_the_post_thumbnail();
						}
						$map_display .= "</a>";
					}
				endwhile;
				else :
					$map_display .= "no stories";
				endif;
				
			}
			$map_display .= '</div>';
			$count++;
		}
		$map_display .= "</div>";
		return $map_display;
	}
	
}
