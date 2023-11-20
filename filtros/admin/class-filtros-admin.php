<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://github.com/hugoybrahim
 * @since      1.0.0
 *
 * @package    Filtros
 * @subpackage Filtros/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Filtros
 * @subpackage Filtros/admin
 * @author     Hugo Ontiveros <ybra72@gmail.com>
 */
class Filtros_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

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
		add_action('init', array($this, 'custom_register_partners_cpt'), 11); 
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
		 * defined in Filtros_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Filtros_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/filtros-admin.css', array(), $this->version, 'all' );

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
		 * defined in Filtros_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Filtros_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/filtros-admin.js', array( 'jquery' ), $this->version, false );

	}

	
    public function custom_register_partners_cpt() {
        $labels = array(
            'name'                  => _x( 'Partners', 'Post Type General Name', 'text_domain' ),
            'singular_name'         => _x( 'Partners', 'Post Type Singular Name', 'text_domain' ),
            'menu_name'             => __( 'Partners', 'text_domain' ),
            'all_items'             => __( 'All Partners', 'text_domain' ),
            'add_new'               => __( 'Add New', 'text_domain' ),
            'add_new_item'          => __( 'Add New Partner', 'text_domain' ),
            'edit_item'             => __( 'Edit Partner', 'text_domain' ),
            'new_item'              => __( 'New Partner', 'text_domain' ),
            'view_item'             => __( 'View Partner', 'text_domain' ),
            'search_items'          => __( 'Search Partners', 'text_domain' ),
            'not_found'             => __( 'No Partners found', 'text_domain' ),
            'not_found_in_trash'    => __( 'No Partners found in Trash', 'text_domain' ),
            'parent_item_colon'     => __( 'Parent Partner:', 'text_domain' )
        );

		$args = array(
			'labels'                => $labels,
			'public'                => true,
			'publicly_queryable'    => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'query_var'             => true,
			'rewrite'               => array( 'slug' => 'partners/%year%/%monthnum%/%day%' ), // Estructura personalizada
			'menu_icon'             => 'dashicons-category',
			'capability_type'       => 'post',
			'has_archive'           => true,
			'hierarchical'          => false,
			'menu_position'         => null,
			'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt' ), 
		);
    
        register_post_type( 'partners', $args );
	}
			
}

