<?php
/**
 * Amorçage du site à l'activation du thème : pages, menu, page d'accueil, blog.
 * Idempotent — relancer l'activation ne duplique rien.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

/**
 * Pages créées automatiquement : slug => [titre, template, contenu].
 *
 * @return array<string, array{title:string, template:string, content:string}>
 */
function mh_seed_pages(): array {
	return array(
		'accueil'    => array(
			'title'    => __( 'Accueil', 'maxime-hypnose' ),
			'template' => '',
			'content'  => '',
		),
		'l-hypnose'  => array(
			'title'    => __( 'L\'hypnose', 'maxime-hypnose' ),
			'template' => 'templates/page-hypnose.php',
			'content'  => '',
		),
		'domaines'   => array(
			'title'    => __( 'Domaines d\'application', 'maxime-hypnose' ),
			'template' => 'templates/page-domaines.php',
			'content'  => '',
		),
		'tarifs'     => array(
			'title'    => __( 'Tarifs & infos pratiques', 'maxime-hypnose' ),
			'template' => 'templates/page-tarifs.php',
			'content'  => '',
		),
		'qui-suis-je' => array(
			'title'    => __( 'Qui suis-je ?', 'maxime-hypnose' ),
			'template' => 'templates/page-apropos.php',
			'content'  => '',
		),
		'contact'    => array(
			'title'    => __( 'Contact & rendez-vous', 'maxime-hypnose' ),
			'template' => 'templates/page-contact.php',
			'content'  => '',
		),
		'blog'       => array(
			'title'    => __( 'Blog', 'maxime-hypnose' ),
			'template' => '',
			'content'  => '',
		),
	);
}

/**
 * Crée les pages, le menu et règle l'affichage à l'activation du thème.
 */
function mh_activate(): void {
	if ( get_option( 'mh_seeded' ) ) {
		return;
	}

	$ids = array();

	foreach ( mh_seed_pages() as $slug => $page ) {
		$existing = get_page_by_path( $slug );

		if ( $existing instanceof WP_Post ) {
			$ids[ $slug ] = $existing->ID;
			continue;
		}

		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_name'    => $slug,
				'post_title'   => $page['title'],
				'post_content' => $page['content'],
				'post_status'  => 'publish',
			)
		);

		if ( is_wp_error( $id ) ) {
			continue;
		}

		if ( '' !== $page['template'] ) {
			update_post_meta( $id, '_wp_page_template', $page['template'] );
		}

		$ids[ $slug ] = $id;
	}

	if ( isset( $ids['accueil'], $ids['blog'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $ids['accueil'] );
		update_option( 'page_for_posts', $ids['blog'] );
	}

	mh_build_menus( $ids );

	update_option( 'mh_seeded', 1 );
}
add_action( 'after_switch_theme', 'mh_activate' );

/**
 * Construit le menu principal et le menu du pied de page.
 *
 * @param array<string,int> $ids Identifiants des pages créées.
 */
function mh_build_menus( array $ids ): void {
	$order = array( 'l-hypnose', 'domaines', 'tarifs', 'qui-suis-je', 'blog', 'contact' );

	foreach ( array( 'primary', 'footer' ) as $location ) {
		$name = 'primary' === $location
			? __( 'Menu principal', 'maxime-hypnose' )
			: __( 'Menu pied de page', 'maxime-hypnose' );

		$menu = wp_get_nav_menu_object( $name );
		$id   = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( $name );

		if ( ! $id || is_wp_error( $id ) ) {
			continue;
		}

		if ( empty( wp_get_nav_menu_items( $id ) ) ) {
			foreach ( $order as $position => $slug ) {
				if ( ! isset( $ids[ $slug ] ) ) {
					continue;
				}

				wp_update_nav_menu_item(
					$id,
					0,
					array(
						'menu-item-object-id' => $ids[ $slug ],
						'menu-item-object'    => 'page',
						'menu-item-type'      => 'post_type',
						'menu-item-status'    => 'publish',
						'menu-item-position'  => $position + 1,
					)
				);
			}
		}

		$locations              = get_theme_mod( 'nav_menu_locations', array() );
		$locations[ $location ] = $id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}
}
