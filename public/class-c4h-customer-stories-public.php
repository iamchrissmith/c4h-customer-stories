<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://teamzen.io
 * @since      1.0.0
 *
 * @package    C4h_Customer_Stories
 * @subpackage C4h_Customer_Stories/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    C4h_Customer_Stories
 * @subpackage C4h_Customer_Stories/public
 * @author     Zenio <support@teamzen.io>
 */
class C4h_Customer_Stories_Public extends C4h_Customer_Stories
{

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		
		wp_enqueue_style( $this->plugin_name, plugins_url( 'css/c4h-customer-stories-public.css', __DIR__ ), array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( 'colorbox', plugin_dir_url( __FILE__ ) . 'js/jquery.colorbox-min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/c4h-customer-stories-public.js', array( 'jquery', 'colorbox' ), $this->version, false );

	}
	
	public function include_shortcode() {
		add_shortcode( 'c4h_customer_stories', array( $this, 'get_map_shortcode' ) );
	}
	
	private function get_list_display( $stories ) {
		$list = '<div class="cs-list">';
		if ( $stories->have_posts() ) : while ( $stories->have_posts() ) : $stories->the_post();
			$story = get_post();
			$story_id = $story->ID;
			$slug = $story->post_name;
			if ( get_post_meta($story_id, '_c4h_cs_story_location') ) {
				$location = get_post_meta($story_id, '_c4h_cs_story_location');
				$location = $location[0];
			} else {
				$location = '';
			}
			if ( get_post_meta($story_id, '_c4h_cs_story_title') ) {
				$headline = get_post_meta($story_id, '_c4h_cs_story_title');
				$headline = $headline[0];
			} else {
				$headline = '';
			}
			$video = FALSE;
			if ( get_post_meta($story_id, '_c4h_cs_video') ) {
				$video = get_post_meta($story_id, '_c4h_cs_video');
				$video = $video[0];
			}
			
			$content = get_the_content();
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			
			if ( ! $video ) {
				$list .= '
					<div class="cs-list-item cs-list-text clearfix" id="'.$slug.'">
						<button type="button" class="cboxClose">X</button>
						<div class="cs-list-details">
							<div class="cs-list-thumbnail">'.get_the_post_thumbnail().'</div>
							<div class="cs-list-title">'.get_the_title().'</div>
							<div class="cs-list-location">'.$location.'</div>
						</div>
						<div class="cs-list-story">
							<div class="cs-list-headline"><h2>'.$headline.'</h2></div>
							<div class="cs-list-content">'.$content.'</div>';
			} else {
				$list .= '
					<div class="cs-list-item cs-list-video clearfix" id="'.$slug.'">
						<button type="button" class="cboxClose">X</button>
						<div class="cs-list-story">
							<div class="cs-list-content">'.$content.'</div>';
			}
			if ( function_exists( 'sharing_display' ) ) {
				$list .= '<div class="cs-social-sharing">'. sharing_display() ."</div>";
			}
			
			$list .="</div></div>";
		endwhile; endif;
		$list .= "</div>";
		return $list;
	}

	public function get_map_shortcode() {
		$stories = $this->get_stories();
		
		$map = $this->cs_get_map_display( 'public', $stories );
		
		$list = $this->get_list_display( $stories );
		
		$html = $map . $list;
		
		return $html;
	}

}
