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


function focuslock_image($attachment_id, $image_size = 'full', $additional_classes = '', $width = null, $height = null) {
  $meta = wp_get_attachment_metadata( $attachment_id );
  $style = '';

  if ($image_size == 'full') {
    $size = [];
    $size['width'] = $meta['width'];
    $size['height'] = $meta['height'];
  } else {
    $size = $meta['sizes'][$image_size];
  }

  if ($width) {
    $style .= 'width: ' . $width . ';';
  }

  if ($height) {
    $style .= 'height: ' . $height . ';';
  }

  $coords = get_post_meta($attachment_id, 'focuslock_coords', true);

  if ($coords) {
    $coords = explode('|', $coords);

    $html = '<div style="' . $style . '" class="focuspoint ' . $additional_classes . '" data-focus-x="' . $coords[0] . '" data-focus-y="' . $coords[1] . '" data-image-w="' . $size['width'] . '" data-image-h="' . $size['height'] . '">';
    $html .= wp_get_attachment_image( $attachment_id, $image_size );
    $html .= '</div>';

    echo $html;
  
  } else {
    echo '';
  }
}