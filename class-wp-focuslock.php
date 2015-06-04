<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WP_FocusLock {

  private static $_instance = null;

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

  public function __construct() {
    $this->plugin_name = 'wp-focuslock';
    $this->version = '0.1';
    $this->load_dependencies();
  }

  public static function instance ( $file = '' ) {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self( $file, '0.1' );
    }
    return self::$_instance;
  }

  private function load_dependencies() {

    require_once( 'admin/class-wp-focuslock-admin.php' );
    $a = new WP_FocusLock_Admin( __FILE__, $this->version );
    //require_once( 'public/class-wp-focuslock-public.php' );
  }

}