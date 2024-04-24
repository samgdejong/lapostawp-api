<?php
/**
 * @package OutboardcareWP
 */
/*
Plugin Name: LapostaWP
Plugin URI: https://samdejong.nl/
Description: Integrates with LaPosta API
Version: 1.0.0
Author: Sam de Jong
Plugin URI: https://samdejong.nl/
License: MIT
*/



if (!defined('ABSPATH')) {
    die;
}

if (!class_exists("LaPostaWP")) {

    class LaPostaWP {

    }
    require_once plugin_dir_path(__FILE__) . 'inc/LapostaApi.php';


}