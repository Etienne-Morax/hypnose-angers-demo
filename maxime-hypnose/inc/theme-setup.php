<?php
/**
 * Déclaration des fonctionnalités du thème.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

/**
 * Supports et menus.
 */
function mh_setup(): void {
	load_theme_textdomain( 'maxime-hypnose', MH_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 64,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_editor_style( 'assets/css/editor.css' );

	add_image_size( 'mh-card', 800, 500, true );
	add_image_size( 'mh-lead', 1400, 760, true );

	register_nav_menus(
		array(
			'primary' => __( 'Navigation principale', 'maxime-hypnose' ),
			'footer'  => __( 'Pied de page', 'maxime-hypnose' ),
			'legal'   => __( 'Mentions légales', 'maxime-hypnose' ),
		)
	);
}
add_action( 'after_setup_theme', 'mh_setup' );

/**
 * Palette et tailles exposées à l'éditeur de blocs, alignées sur les tokens CSS.
 * Indispensable pour que les articles générés automatiquement restent dans la charte.
 */
function mh_editor_palette(): void {
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Encre', 'maxime-hypnose' ),
				'slug'  => 'ink',
				'color' => '#1f3830',
			),
			array(
				'name'  => __( 'Sable', 'maxime-hypnose' ),
				'slug'  => 'sand',
				'color' => '#f7f4ec',
			),
			array(
				'name'  => __( 'Terracotta', 'maxime-hypnose' ),
				'slug'  => 'clay',
				'color' => '#c2703f',
			),
			array(
				'name'  => __( 'Sauge', 'maxime-hypnose' ),
				'slug'  => 'sage',
				'color' => '#6f8f80',
			),
			array(
				'name'  => __( 'Blanc', 'maxime-hypnose' ),
				'slug'  => 'white',
				'color' => '#ffffff',
			),
		)
	);

	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name' => __( 'Petit', 'maxime-hypnose' ),
				'slug' => 'small',
				'size' => 15,
			),
			array(
				'name' => __( 'Normal', 'maxime-hypnose' ),
				'slug' => 'normal',
				'size' => 17,
			),
			array(
				'name' => __( 'Grand', 'maxime-hypnose' ),
				'slug' => 'large',
				'size' => 21,
			),
			array(
				'name' => __( 'Titre', 'maxime-hypnose' ),
				'slug' => 'huge',
				'size' => 34,
			),
		)
	);

	add_theme_support( 'disable-custom-colors' );
}
add_action( 'after_setup_theme', 'mh_editor_palette' );

/**
 * Zones de widgets.
 */
function mh_widgets(): void {
	register_sidebar(
		array(
			'name'          => __( 'Colonne du blog', 'maxime-hypnose' ),
			'id'            => 'blog-sidebar',
			'description'   => __( 'Affichée à côté de la liste des articles.', 'maxime-hypnose' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget__title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'mh_widgets' );

/**
 * Longueur des extraits, adaptée aux cartes du blog.
 *
 * @return int
 */
function mh_excerpt_length(): int {
	return 28;
}
add_filter( 'excerpt_length', 'mh_excerpt_length' );

/**
 * Suffixe des extraits.
 *
 * @return string
 */
function mh_excerpt_more(): string {
	return '…';
}
add_filter( 'excerpt_more', 'mh_excerpt_more' );

/**
 * Classes utilitaires sur le body.
 *
 * @param array $classes Classes existantes.
 * @return array
 */
function mh_body_classes( array $classes ): array {
	if ( ! is_singular() ) {
		$classes[] = 'is-listing';
	}

	if ( is_front_page() ) {
		$classes[] = 'is-home';
	}

	return $classes;
}
add_filter( 'body_class', 'mh_body_classes' );
