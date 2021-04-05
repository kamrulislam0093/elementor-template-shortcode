<?php 
/**
  * Plugin Name:       Elementor Template Shortcode
  * Plugin URI:        https://#
  * Description:       Elementor Template Shortcode helps to display Elementor Builder Content.
  * Version:           1.0
  * Requires at least: 5.2
  * Requires PHP:      7.2
  * Author:            Kamrul Islam
  * Author URI:        https://#
  * License:           GPL v2 or later
  * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
  * Text Domain:       et_shortcode
  * Domain Path:       /languages
  * 
  * @package Elementor
  * @category Core
  *

   Elementor Template Shortcode is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   any later version.

   Elementor Template Shortcode is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with Elementor Template Shortcode.
*/


if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

require_once plugin_dir_path( __FILE__ ) . 'includes/admin-notices.php';

/**
 *  Elementor Template Shortcode Main Class
 */
class ETShortcode {
  
  public $version = 1.0;


  /**
   * The single instance of the class.
   *
   * @var WooCommerce
   * @since 1.0
   */
  protected static $_instance = null;



  function __construct() {
    $this->define_constants();

    register_activation_hook( __FILE__, [$this, 'ets_register_activation_hook'] );

    add_action( 'wp_footer', [$this, 'ETShorcode_footer'] );
  }

  public function ETShorcode_footer() {
    echo "string";
  }

  /**
   * Main ETShortcode Instance.
   *
   * Ensures only one instance of ETShortcode is loaded or can be loaded.
   *
   * @since 1.0
   * @static
   * @see ETS()
   * @return ETShortcode - Main instance.
   */
  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }


  /**
   * Define ETShortcode Constants.
   */
  public function define_constants() {
    $this->define( 'ETS_DIR_PATH', plugin_dir_path(__FILE__));
    $this->define( 'ETS_DIR_URL', plugin_dir_url(__FILE__));
    $this->define( 'ETS_VERSION', $this->version );  
  }

  /**
   * Define constant if not already set.
   *
   * @param string      $name  Constant name.
   * @param string|bool $value Constant value.
   */
  private function define( $name, $value ) {
    if ( ! defined( $name ) ) {
      define( $name, $value );
    }
  }

  public function ets_register_activation_hook() {
    add_option( Elementor_Template_Shortcode, true );
  }

}




/**
 * Returns the main instance of ETShortcode.
 *
 * @since  1.0
 * @return ETShortcode
 */
function ETS() {
  return ETShortcode::instance();
}


if ( did_action( 'elementor/loaded' ) && !function_exists( 'elementor_pro_load_plugin' ) ) {
  $GLOBALS['etshortcode'] = ETS();
} else {
  add_action( 'admin_notices', 'admin_notice_missing_main_plugin' );
}


// Global for backwards compatibility.

