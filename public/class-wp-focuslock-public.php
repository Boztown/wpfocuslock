<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WP_FocusLock_Admin {

  /**
   * The version number.
   * @var     string
   * @access  public
   */
  public $_version;

  /**
   * The main plugin file.
   * @var     string
   * @access  public
   */
  public $file;

  /**
   * The main plugin directory.
   * @var     string
   * @access  public
   */
  public $dir;

  /**
   * Constructor function.
   * @access  public
   * @return  void
   */
  public function __construct ( $file = '', $version = '1.0.0' ) {
    //add_action( 'wp_enqueue_scripts', array( $this, 'public_enqueue_styles' ), 10, 1 );
    //add_action( 'wp_enqueue_scripts', array( $this, 'public_enqueue_scripts' ), 10, 1 );
  }

  /**
   * Register the stylesheets for the public area.
   *
   */
  public function public_enqueue_styles() {
    wp_enqueue_style( 'FocusLockPublicStyles', plugin_dir_url( __FILE__ ) . 'css/focuslock-admin.css');
  }

  /**
   * Register the scripts for the public area.
   *
   */
  public function public_enqueue_scripts() {
    wp_enqueue_script( 'FocusLockPublicScripts', plugin_dir_url( __FILE__ ) . 'js/main.js', array('jquery'), $this->_version, true );
  }
}