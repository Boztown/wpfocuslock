<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WP_FocusLock_Public {

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
    add_action( 'wp_enqueue_scripts', array( $this, 'public_enqueue_styles' ), 10, 1 );
    add_action( 'wp_enqueue_scripts', array( $this, 'public_enqueue_scripts' ), 10, 1 );
  }

  /**
   * Register the stylesheets for the public area.
   *
   */
  public function public_enqueue_styles() {
    wp_enqueue_style( 'jquery_focuspoint_css', plugin_dir_url( __FILE__ ) . 'css/focuspoint.css');
  }

  /**
   * Register the scripts for the public area.
   *
   */
  public function public_enqueue_scripts() {
    wp_enqueue_script( 'jquery_focuspoint', plugin_dir_url( __FILE__ ) . 'js/jquery.focuspoint.min.js', array('jquery'), $this->_version, true );
    wp_enqueue_script( 'wp_focuslock', plugin_dir_url( __FILE__ ) . 'js/wp-focuslock.js', array('jquery', 'jquery_focuspoint'), $this->_version, true );
  }
}


function focuslock_image($attachment_id) {
  $attachment = get_post($attachment_id);
  $coords = get_post_meta($attachment_id, 'focuslock_coords', true);
  print_r($coords);
}