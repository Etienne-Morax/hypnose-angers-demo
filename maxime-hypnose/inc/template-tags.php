<?php
/**
 * Fonctions d'affichage réutilisables : icônes, méta, fil d'Ariane.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

/**
 * Jeu d'icônes SVG (style trait Lucide, 1.5px, 24×24).
 *
 * @param string $name Identifiant de l'icône.
 * @param int    $size Taille en pixels.
 * @return string SVG échappé prêt à l'affichage.
 */
function mh_icon( string $name, int $size = 24 ): string {
	$paths = array(
		'arrow-right' => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
		'arrow-left'  => '<path d="M19 12H5"/><path d="m12 19-7-7 7-7"/>',
		'phone'       => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/>',
		'mail'        => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
		'pin'         => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
		'clock'       => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
		'check'       => '<path d="M20 6 9 17l-5-5"/>',
		'shield'      => '<path d="M20 13c0 5-3.5 7.5-7.7 9a1 1 0 0 1-.6 0C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.2-2.7a1 1 0 0 1 1.6 0C14.5 3.8 17 5 19 5a1 1 0 0 1 1 1Z"/><path d="m9 12 2 2 4-4"/>',
		'leaf'        => '<path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.5 19 2c1 2 2 4.2 2 8 0 5.5-4.8 10-10 10Z"/><path d="M2 21c0-3 1.9-5.7 4.5-7.5C9 11.7 12 11 12 11"/>',
		'moon'        => '<path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/>',
		'wind'        => '<path d="M12.8 19.6A2 2 0 1 0 14 16H2"/><path d="M17.5 8a2.5 2.5 0 1 1 2 4H2"/><path d="M9.8 4.4A2 2 0 1 1 11 8H2"/>',
		'cigarette'   => '<path d="M18 12H2v4h16"/><path d="M22 12v4"/><path d="M18 8c0-2-2-2-2-4"/><path d="M22 8c0-2-2-2-2-4"/>',
		'utensils'    => '<path d="M3 2v7c0 1.1.9 2 2 2h1a2 2 0 0 0 2-2V2"/><path d="M6 11v11"/><path d="M17 2v20"/><path d="M21 6c0 3-2 4-4 4"/>',
		'heart'       => '<path d="M19 14c1.5-1.5 3-3.4 3-5.5A5.5 5.5 0 0 0 12 5.5 5.5 5.5 0 0 0 2 8.5c0 2.1 1.5 4 3 5.5l7 7Z"/>',
		'sparkles'    => '<path d="M12 3 13.9 8.6 19.5 10.5 13.9 12.4 12 18 10.1 12.4 4.5 10.5 10.1 8.6Z"/><path d="M19 15v4"/><path d="M17 17h4"/>',
		'star'        => '<path d="m12 2 3.1 6.3 6.9 1-5 4.9 1.2 6.8-6.2-3.3-6.2 3.3L7 14.2l-5-4.9 6.9-1Z" fill="currentColor" stroke="none"/>',
		'quote'       => '<path d="M10 11H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v8a4 4 0 0 1-4 4"/><path d="M20 11h-4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v8a4 4 0 0 1-4 4"/>',
		'calendar'    => '<rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 2v4"/><path d="M16 2v4"/>',
		'user'        => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
	);

	if ( ! isset( $paths[ $name ] ) ) {
		return '';
	}

	return sprintf(
		'<svg width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%2$s</svg>',
		$size,
		$paths[ $name ]
	);
}

/**
 * Affiche une icône.
 *
 * @param string $name Identifiant.
 * @param int    $size Taille.
 */
function mh_the_icon( string $name, int $size = 24 ): void {
	echo wp_kses( mh_icon( $name, $size ), mh_svg_allowed_tags() );
}

/**
 * Balises SVG autorisées pour wp_kses.
 *
 * @return array<string, array<string, bool>>
 */
function mh_svg_allowed_tags(): array {
	$attrs = array(
		'width'            => true,
		'height'           => true,
		'viewbox'          => true,
		'fill'             => true,
		'stroke'           => true,
		'stroke-width'     => true,
		'stroke-linecap'   => true,
		'stroke-linejoin'  => true,
		'aria-hidden'      => true,
		'focusable'        => true,
		'class'            => true,
		'd'                => true,
		'cx'               => true,
		'cy'               => true,
		'r'                => true,
		'x'                => true,
		'y'                => true,
		'rx'               => true,
		'opacity'          => true,
		'transform'        => true,
		'points'           => true,
	);

	return array(
		'svg'     => $attrs,
		'path'    => $attrs,
		'circle'  => $attrs,
		'rect'    => $attrs,
		'ellipse' => $attrs,
		'g'       => $attrs,
	);
}

/**
 * Méta d'un article : date, catégorie, temps de lecture.
 */
function mh_post_meta(): void {
	$minutes = mh_reading_time( get_the_content() );
	?>
	<div class="post-card__meta">
		<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		<?php
		$categories = get_the_category();
		if ( ! empty( $categories ) ) :
			?>
			<span aria-hidden="true">·</span>
			<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>"><?php echo esc_html( $categories[0]->name ); ?></a>
		<?php endif; ?>
		<span aria-hidden="true">·</span>
		<span><?php echo esc_html( sprintf( /* translators: %d: minutes. */ __( '%d min de lecture', 'maxime-hypnose' ), $minutes ) ); ?></span>
	</div>
	<?php
}

/**
 * Temps de lecture estimé (230 mots/minute).
 *
 * @param string $content Contenu brut.
 * @return int
 */
function mh_reading_time( string $content ): int {
	$words = str_word_count( wp_strip_all_tags( $content ) );

	return max( 1, (int) ceil( $words / 230 ) );
}

/**
 * Fil d'Ariane simple, affiché sur les pages internes.
 */
function mh_breadcrumbs(): void {
	if ( is_front_page() ) {
		return;
	}
	?>
	<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Fil d\'Ariane', 'maxime-hypnose' ); ?>">
		<span><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Accueil', 'maxime-hypnose' ); ?></a></span>
		<?php if ( is_singular( 'post' ) ) : ?>
			<span><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'Blog', 'maxime-hypnose' ); ?></a></span>
		<?php endif; ?>
		<span aria-current="page"><?php echo esc_html( wp_strip_all_tags( mh_current_title() ) ); ?></span>
	</nav>
	<?php
}

/**
 * Titre de la vue courante, tous contextes confondus.
 *
 * @return string
 */
function mh_current_title(): string {
	if ( is_singular() ) {
		return get_the_title();
	}

	if ( is_category() || is_tag() || is_tax() ) {
		return single_term_title( '', false );
	}

	if ( is_search() ) {
		/* translators: %s: search terms. */
		return sprintf( __( 'Recherche : %s', 'maxime-hypnose' ), get_search_query() );
	}

	if ( is_404() ) {
		return __( 'Page introuvable', 'maxime-hypnose' );
	}

	return __( 'Blog', 'maxime-hypnose' );
}

/**
 * Illustration vectorielle du héros : cercles concentriques évoquant la respiration.
 * Aucun bitmap chargé, donc aucun coût réseau ni décalage de mise en page.
 */
function mh_hero_visual(): void {
	?>
	<svg class="hero__orb" viewBox="0 0 460 460" role="img"
		aria-label="<?php esc_attr_e( 'Illustration abstraite de cercles concentriques évoquant une respiration lente', 'maxime-hypnose' ); ?>">
		<defs>
			<radialGradient id="mh-orb" cx="42%" cy="36%">
				<stop offset="0%" stop-color="#f6e2d2"/>
				<stop offset="55%" stop-color="#dfd0bd"/>
				<stop offset="100%" stop-color="#c9d3c9"/>
			</radialGradient>
		</defs>
		<circle cx="230" cy="230" r="212" fill="url(#mh-orb)"/>
		<g fill="none" stroke="#1f3830" stroke-opacity="0.16">
			<circle cx="230" cy="230" r="176"/>
			<circle cx="230" cy="230" r="140"/>
			<circle cx="230" cy="230" r="104"/>
			<circle cx="230" cy="230" r="68"/>
		</g>
		<circle class="hero__orb-pulse" cx="230" cy="230" r="32" fill="#c2703f" fill-opacity="0.9"/>
	</svg>
	<?php
}
