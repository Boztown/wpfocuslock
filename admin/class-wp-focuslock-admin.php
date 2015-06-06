<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class WP_FocusLock_Admin {

  /**
   * The version number.
   * @var     string
   * @access  public
   */
  public $version;

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

    $this->version = $version;
    $this->file = $file;

    add_filter( 'attachment_fields_to_edit', array( $this, 'media_field_setup' ), 10, 2 );
    add_action( 'edit_attachment', array( $this, 'save_attachment') );
    
    // Load admin JS & CSS
    add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ), 10, 1 );
    add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 10, 1 );
  
    add_shortcode( 'focuslock', array( $this, 'focuslock_shortcode') );

    add_action( 'wp_ajax_get_focus_points', array( $this, 'get_focus_points' ) );
    add_action( 'wp_ajax_save_focus_points', array( $this, 'save_focus_points' ) );
  }


  public function media_field_setup($form_fields, $attachment) {

    $image = wp_get_attachment_image_src( $attachment->ID, 'medium' );

    $html = '<div class="focuslock-ui hide-if-no-js">';
    $html .= '<div class="focuslock-image-wrapper image-wrapper locked">';
    $html .= '<img src="' . $image[0] . '" data-attachment-id="' . $attachment->ID . '" />';
    $html .= '</div>'; // end image-wrapper
    $html .= '<hr>';
    $html .= '<button class="button edit-focuslock" type="button" data-attachment-id="' . $attachment->ID . '">Edit Focus Lock</button>';
    $html .= '<button class="button save-focuslock" type="button" data-attachment-id="' . $attachment->ID . '">Save</button>';
    $html .= '<button class="button cancel-focuslock" type="button">Cancel</button>';
    $html .= '<p class="saved-message">Saved.</p>';
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

  public function get_focus_points() {
    $att_id = isset( $_POST[ 'attachment_id' ] ) ? intval( $_POST[ 'attachment_id' ] ) : false;

    if ( $att_id ) {

      $focuslock_coords = get_post_meta( $att_id, 'focuslock_coords', true );
      $focuslock_mouse_coords = get_post_meta( $att_id, 'focuslock_mouse_coords', true );

      $response = array(
        'focuslock_coords' => $focuslock_coords,
        'focuslock_mouse_coords' => $focuslock_mouse_coords
      );
    }

    $this->send_json( $response );
  }

  public function save_focus_points() {
    $attachment_id = isset( $_POST[ 'attachment_id' ] ) ? intval( $_POST[ 'attachment_id' ] ) : false;

    if ( $attachment_id ) {
      $focuslock_coords = $_POST['focuslock_coords'];
      $focuslock_mouse_coords = $_POST['focuslock_mouse_coords'];
      update_post_meta( $attachment_id, 'focuslock_coords', $focuslock_coords );
      update_post_meta( $attachment_id, 'focuslock_mouse_coords', $focuslock_mouse_coords );
    }
  }

  public function save_attachment( $attachment_id ) {
      if ( isset( $_REQUEST['attachments'][$attachment_id]['focuslock_coords'] ) ) {
          $focuslock_coords = $_REQUEST['attachments'][$attachment_id]['focuslock_coords'];
          $focuslock_mouse_coords = $_REQUEST['attachments'][$attachment_id]['focuslock_mouse_coords'];
          update_post_meta( $attachment_id, 'focuslock_coords', $focuslock_coords );
          update_post_meta( $attachment_id, 'focuslock_mouse_coords', $focuslock_mouse_coords );
      }
  }

  public function send_json( $response ) {
    header( 'Content-type: application/json' );
    echo json_encode( $response );
    exit;
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
    wp_enqueue_script( 'FocusLockAdminScripts', plugin_dir_url( __FILE__ ) . 'js/main.js', array('jquery'), $this->version, true );
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

    if (isset($atts['width'])) {
      $width = $atts['width'];
    } else {
      $width = null;
    }

    if (isset($atts['height'])) {
      $height = $atts['height'];
    } else {
      $height = null;
    }

    return focuslock_image($atts['id'], $size, $classes, $width, $height);
  }
}