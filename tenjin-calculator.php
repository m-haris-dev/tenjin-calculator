<?php
/**
* Plugin Name: Tenjin Calculator
* Plugin URI: https://clickysoft.com/
* Description: Tenjin Calculator Plugin
* Version: 1.0.0
* Author: clickysoft
* Author URI: https://clickysoft.com/
* License: GPL2
*/
defined('ABSPATH') or die('Hey, you can\t access this file');

if ( ! defined( 'TECA_PLUGIN_DIR' ) ) {
	define( 'TECA_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

require_once TECA_PLUGIN_DIR . '/class-teca-plugin-loader.php';