<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WP_FocusLock {

  /**
   * The single instance of WP_FocusLock.
   * @var   object
   * @access  private
   * @since   1.0.0
   */
  private static $_instance = null;

  /**
   * Settings class object
   * @var     object
   * @access  public
   * @since   1.0.0
   */
  public $settings = null;

  /**
   * The version number.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $_version;

  /**
   * The token.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $_token;

  /**
   * The main plugin file.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $file;

  /**
   * The main plugin directory.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $dir;

  /**
   * The plugin assets directory.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $assets_dir;

  /**
   * The plugin assets URL.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $assets_url;

  /**
   * Suffix for Javascripts.
   * @var     string
   * @access  public
   * @since   1.0.0
   */
  public $script_suffix;

  public $update_package;
  public $current_user;
  public $secret_key;
  public $payload;

  /**
   * Constructor function.
   * @access  public
   * @since   1.0.0
   * @return  void
   */
  public function __construct ( $file = '', $version = '1.0.0' ) {
    $this->_version = $version;
    $this->_token = 'wp_focuslock';

    // Load plugin environment variables
    $this->file = $file;
    $this->dir = dirname( $this->file );
    $this->assets_dir = trailingslashit( $this->dir ) . 'assets';
    $this->assets_url = esc_url( trailingslashit( plugins_url( '/assets/', $this->file ) ) );

    $this->script_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

    //register_activation_hook( $this->file, array( $this, 'install' ) );

    add_action('init', array( $this, 'init_hook'));

    add_filter( 'attachment_fields_to_edit', array( $this, 'media_field_setup' ), 10, 2 );
    
    // Load frontend JS & CSS
    //add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 10 );
    //dd_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 10 );

    // Load admin JS & CSS
    add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ), 10, 1 );
    add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );
  } // End __construct ()


  /**
   * Main WP_FocusLock Instance
   *
   * Ensures only one instance of WP_FocusLock is loaded or can be loaded.
   *
   * @since 1.0.0
   * @static
   * @see WP_FocusLock()
   * @return Main WP_FocusLock instance
   */
  public static function instance ( $file = '', $version = '1.0.0' ) {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self( $file, $version );
    }
    return self::$_instance;
  } // End instance ()


  public function init_hook() {

  }

  public function media_field_setup($form_fields, $attachment) {

    $image = wp_get_attachment_image_src( $attachment->ID, 'medium' );

    $html = '<div class="focuslock-ui hide-if-no-js">';
    $html = '<div id="focuslock-image-wrapper" class="image-wrapper">';
    $html .= '<img src="' . $image[0] . '" />';
    $html .= '</div>'; // end image-wrapper
    $html .= '</div>'; // end focuslock-ui

    $form_fields[ 'focus_lock' ] = array(
      'label' => __( 'Focus Lock' ),
      'input' => 'html',
      'html' => $html
    );

    return $form_fields;
  }

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    1.0.0
   */
  public function admin_enqueue_styles() {
    wp_enqueue_style( 'FocusLockAdminStyles', plugin_dir_url( __FILE__ ) . 'css/focuslock-admin.css');
  }

  /**
   * Register the scripts for the admin area.
   *
   * @since    1.0.0
   */
  public function admin_enqueue_scripts() {
    wp_enqueue_script( 'FocusLockAdminScripts', plugin_dir_url( __FILE__ ) . 'js/main.js', array('jquery'), $this->_version, true );
  }
}