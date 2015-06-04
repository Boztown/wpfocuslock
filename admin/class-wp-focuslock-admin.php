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

    add_filter( 'attachment_fields_to_edit', array( $this, 'media_field_setup' ), 10, 2 );
    add_action( 'edit_attachment', array( $this, 'save_attachment') );
    
    // Load admin JS & CSS
    add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ), 10, 1 );
    add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );
  
    add_shortcode( 'focuslock', array( $this, 'focuslock_shortcode') );
  }


  public function media_field_setup($form_fields, $attachment) {

    $image = wp_get_attachment_image_src( $attachment->ID, 'medium' );

    $html = '<div class="focuslock-ui hide-if-no-js">';
    $html = '<div id="focuslock-image-wrapper" class="image-wrapper">';
    $html .= '<img src="' . $image[0] . '" />';
    $html .= '</div>'; // end image-wrapper
    $html .= '</div>'; // end focuslock-ui

    $focuslock_coords = get_post_meta( $attachment->ID, 'focuslock_coords', true );
    $form_fields['focuslock_coords'] = array(
        'value' => $focuslock_coords ? $focuslock_coords : '',
        'label' => __( 'Coords' ),
        'input' => 'hidden'
    );

    $focuslock_mouse_coords = get_post_meta( $attachment->ID, 'focuslock_mouse_coords', true );
    $form_fields['focuslock_mouse_coords'] = array(
        'value' => $focuslock_mouse_coords ? $focuslock_mouse_coords : '',
        'label' => __( 'Coords' ),
        'input' => 'hidden'
    );

    $form_fields[ 'focus_lock' ] = array(
      'label' => __( 'Focus Lock' ),
      'input' => 'html',
      'html' => $html
    );

    return $form_fields;
  }

  public function save_attachment( $attachment_id ) {
      if ( isset( $_REQUEST['attachments'][$attachment_id]['focuslock_coords'] ) ) {
          $focuslock_coords = $_REQUEST['attachments'][$attachment_id]['focuslock_coords'];
          $focuslock_mouse_coords = $_REQUEST['attachments'][$attachment_id]['focuslock_mouse_coords'];
          update_post_meta( $attachment_id, 'focuslock_coords', $focuslock_coords );
          update_post_meta( $attachment_id, 'focuslock_mouse_coords', $focuslock_mouse_coords );
      }
  }

  /**
   * Register the stylesheets for the admin area.
   *
   */
  public function admin_enqueue_styles() {
    wp_enqueue_style( 'FocusLockAdminStyles', plugin_dir_url( __FILE__ ) . 'css/focuslock-admin.css');
  }

  /**
   * Register the scripts for the admin area.
   *
   */
  public function admin_enqueue_scripts() {
    wp_enqueue_script( 'FocusLockAdminScripts', plugin_dir_url( __FILE__ ) . 'js/main.js', array('jquery'), $this->_version, true );
  }

  public function focuslock_shortcode( $atts , $content = null ) {
    
    if (isset($atts['size'])) {
      $size = $atts['size'];
    } else {
      $size = 'large';
    }

    if (isset($atts['classes'])) {
      $classes = $atts['classes'];
    } else {
      $classes = '';
    }

    return focuslock_image($atts['id'], $size, $classes);
  }
}