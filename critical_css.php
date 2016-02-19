<?php
/*
Plugin Name: Critical Css
Plugin URI: http://samuelbrynolf.se/critical-css-for-wordpress
Description: Backend support for the concept of laoding critical css inline. Totally inspired, and credited to Chris Ferdinandi. Reference: http://gomakethings.com/inlining-critical-css-for-better-web-performance/
Author: Samuel Brynolf
Author URI: http://samuelbrynolf.se
Version: 1.0
*/

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)){
    die('Invalid URL');
}

// ADD A "SHOW STATUS"-OPTION
// ADD DOCUMENTATION FOR IS_PLUGIN_ACTIVE FOR PLUGIN
// DOUBLECHECK https://codex.wordpress.org/Function_Reference/esc_url IN SETTINGS TO GET REAL PATHS

class critical_css {
    public function __construct(){
        add_action('plugins_loaded', array(&$this, 'ccss_constants' ), 1);
        add_action('plugins_loaded', array(&$this, 'ccss_includes' ), 2);
    }

    public function ccss_constants(){
        define('ccss_DIR', plugin_dir_path( __FILE__ ));
        define('ccss_INCLUDES', ccss_DIR . trailingslashit('ccss_includes'));
    }

    public function ccss_includes(){
        require_once( ccss_INCLUDES . 'ccss_settings.php');
        require_once( ccss_INCLUDES . 'ccss_functions.php');
    }
}

new critical_css();