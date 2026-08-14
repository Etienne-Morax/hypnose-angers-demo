<?php
/**
 * Point d'entrée du thème Maxime Hypnose.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

define( 'MH_VERSION', '1.0.0' );
define( 'MH_DIR', get_template_directory() );
define( 'MH_URI', get_template_directory_uri() );

require_once MH_DIR . '/inc/theme-setup.php';
require_once MH_DIR . '/inc/enqueue.php';
require_once MH_DIR . '/inc/template-tags.php';
require_once MH_DIR . '/inc/customizer.php';
require_once MH_DIR . '/inc/contact-form.php';
require_once MH_DIR . '/inc/seo.php';
require_once MH_DIR . '/inc/demo-content.php';
