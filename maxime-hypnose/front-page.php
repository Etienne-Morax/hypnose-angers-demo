<?php
/**
 * Page d'accueil.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

get_header();

get_template_part( 'template-parts/section', 'hero' );
get_template_part( 'template-parts/section', 'domaines' );
get_template_part( 'template-parts/section', 'approche' );
get_template_part( 'template-parts/section', 'seance' );
get_template_part( 'template-parts/section', 'tarifs' );
get_template_part( 'template-parts/section', 'temoignages' );
get_template_part( 'template-parts/section', 'articles' );
get_template_part( 'template-parts/section', 'faq' );
get_template_part( 'template-parts/section', 'contact' );

get_footer();
