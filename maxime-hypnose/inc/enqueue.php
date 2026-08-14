<?php
/**
 * Chargement des feuilles de style et scripts.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

/**
 * Préconnexion aux domaines de polices, avant le chargement de la CSS.
 *
 * @param array  $urls          URLs déjà déclarées.
 * @param string $relation_type Type de relation.
 * @return array
 */
function mh_resource_hints( array $urls, string $relation_type ): array {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'mh_resource_hints', 10, 2 );

/**
 * Feuilles de style et script du thème.
 */
function mh_assets(): void {
	wp_enqueue_style(
		'mh-fonts',
		'https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;1,400&family=Raleway:wght@400;500;600&display=swap',
		array(),
		null // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- URL déjà versionnée.
	);

	$sheets = array( 'tokens', 'base', 'layout', 'components', 'blog' );
	$deps   = array( 'mh-fonts' );

	foreach ( $sheets as $sheet ) {
		$handle = 'mh-' . $sheet;

		wp_enqueue_style(
			$handle,
			MH_URI . "/assets/css/{$sheet}.css",
			$deps,
			MH_VERSION
		);

		$deps = array( $handle );
	}

	// style.css ne porte que l'en-tête du thème, mais WordPress attend son enregistrement.
	wp_enqueue_style( 'mh-style', get_stylesheet_uri(), $deps, MH_VERSION );

	wp_enqueue_script(
		'mh-main',
		MH_URI . '/assets/js/main.js',
		array(),
		MH_VERSION,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mh_assets' );

/**
 * Styles de l'éditeur de blocs (back-office).
 */
function mh_editor_assets(): void {
	wp_enqueue_style(
		'mh-editor-tokens',
		MH_URI . '/assets/css/tokens.css',
		array(),
		MH_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'mh_editor_assets' );
