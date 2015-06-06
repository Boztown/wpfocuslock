<?php
/*
 * Plugin Name: WP Focus Lock
 * Version: 0.4
 * Plugin URI: http://www.neota.net
 * Description: Lock down that FOCUS.
 * Author: Ryan Bosinger @ Neota Inc.
 * Author URI: http://www.neota.net
 * Requires at least: 4.0
 * Tested up to: 4.0
 * GitHub Plugin URI: Boztown/wpfocuslock
 * Text Domain: wp-focuslock
 * Domain Path: /lang/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Load plugin class files
require_once( 'class-wp-focuslock.php' );

/**
 * Returns the main instance of WP_FocusLock to prevent the need to use globals.
 *
 * @return object FocusLock_Plugin
 */
function WP_FocusLock() {
  $instance = WP_FocusLock::instance( __FILE__ );
  return $instance;
}

WP_FocusLock();