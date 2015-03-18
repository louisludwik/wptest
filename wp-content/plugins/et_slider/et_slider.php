<?php
/*
Plugin Name: ET Slider
Plugin URI: www.enginethemes.com
Description: A plugin from EngineThemes to include beautiful sliders in your website easily
Version: 1.0
Author: EngineThemes team
Author URI: www.enginethemes.com
License: GPL2
*/
define ('ET_SLIDER_VERSION', 1.0);
//require_once dirname(__FILE__) . '/update.php';
//require_once dirname(__FILE__) . '/register_post_type.php';
require_once dirname(__FILE__) . '/inc/base.php';
require_once dirname(__FILE__) . '/inc/et_slider.php';
require_once dirname(__FILE__) . '/front.php';
//require_once dirname(__FILE__) . '/inc/et_attachment.php';
require_once dirname(__FILE__) . '/admin.php';
require_once dirname(__FILE__) . '/inc/widget.php';
require_once dirname(__FILE__) . '/update.php'; 


if (is_admin()){
	new ET_Slider();
	new ET_Slider_Admin();
}

// $value = get_option('et_general_opts');//et_options
// $value['et_customization']['action'];
