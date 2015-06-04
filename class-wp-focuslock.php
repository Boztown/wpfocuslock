<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WP_FocusLock {

  private static $_instance = null;

  /**
   * The unique identifier of this plugin.
   *
   * @access   protected
   * @var      string    $plugin_name    The string used to uniquely identify this plugin.
   */
  protected $plugin_name;

  /**
   * The main plugin file.
   * @var     string
   * @access  public
   */
  public $file;

  /**
   * The current version of the plugin.
   *
   * @access   protected
   * @var      string    $version    The current version of the plugin.
   */
  protected $version;

  public function __construct( $file, $version ) {
    $this->plugin_name = 'wp-focuslock';
    $this->version = $version;
    $this->load_dependencies();
  }

  public static function instance ( $file = '' ) {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self( $file, '0.2' );
    }
    return self::$_instance;
  }

  private function load_dependencies() {

    require_once( 'admin/class-wp-focuslock-admin.php' );
    $admin = new WP_FocusLock_Admin( __FILE__, $this->version );
    require_once( 'public/class-wp-focuslock-public.php' );
    $public = new WP_FocusLock_Public( __FILE__, $this->version );
  }

}