<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://github.com/hugoybrahim
 * @since             1.0.0
 * @package           Filtros
 *
 * @wordpress-plugin
 * Plugin Name:       Filtros
 * Plugin URI:        https://filtros.com
 * Description:       Filtros y resultados de partners
 * Version:           1.0.0
 * Author:            Hugo Ontiveros
 * Author URI:        https://https://github.com/hugoybrahim/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       filtros
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FILTROS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-filtros-activator.php
 */
function activate_filtros() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-filtros-activator.php';
	Filtros_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-filtros-deactivator.php
 */
function deactivate_filtros() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-filtros-deactivator.php';
	Filtros_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_filtros' );
register_deactivation_hook( __FILE__, 'deactivate_filtros' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-filtros.php';
require plugin_dir_path( __FILE__ ) . 'public/ajax/filtros-ajax.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_filtros() {

	$plugin = new Filtros();
	$plugin->run();

}
run_filtros();

// Registro de plantilla personalizada
function custom_template_register($templates) {
    $plugin_template = plugin_dir_path(__FILE__) . 'template.php';
    $templates['template.php'] = __('Filtros', 'filtros');
    return $templates;
}

add_filter('theme_page_templates', 'custom_template_register');

function custom_template_include($template) {
    if (is_page_template('template.php')) {
        $template = plugin_dir_path(__FILE__) . 'template.php';
    }
    return $template;
}

add_filter('template_include', 'custom_template_include');

function custom_register_specialty_taxonomy() {
    register_taxonomy(
        'specialty',
        'partners',
        array(
            'label' => 'Specialties',
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'specialty' ),
        )
    );
}
add_action( 'init', 'custom_register_specialty_taxonomy' );

function custom_register_country_taxonomy() {
    register_taxonomy(
        'country',
        'partners',
        array(
            'label' => 'Countries',
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'country' ),
        )
    );
}
add_action( 'init', 'custom_register_country_taxonomy' );

function custom_partners_permalink_structure($post_link, $post) {
    if (is_object($post) && $post->post_type == 'partners') {
        $post_link = home_url('/partners/' . date('Y/m/d', strtotime($post->post_date)) . '/' . $post->post_name . '/');
    }
    return $post_link;
}

add_filter('post_type_link', 'custom_partners_permalink_structure', 10, 2);

function custom_template($template) {
    if (is_singular('partners')) {
        $template = plugin_dir_path(__FILE__) . 'single-partners.php';
    }
    return $template;
}
add_filter('single_template', 'custom_template');