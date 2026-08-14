<?php
/**
 * Données structurées et métadonnées sociales.
 * Utile en soi, et utile aux articles publiés automatiquement.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

/**
 * JSON-LD : fiche établissement sur toutes les pages, article sur les billets.
 */
function mh_structured_data(): void {
	$business = array(
		'@context'    => 'https://schema.org',
		'@type'       => array( 'LocalBusiness', 'HealthAndBeautyBusiness' ),
		'@id'         => home_url( '/#cabinet' ),
		'name'        => get_bloginfo( 'name' ),
		'description' => get_bloginfo( 'description' ),
		'url'         => home_url( '/' ),
		'telephone'   => mh_get( 'mh_phone' ),
		'email'       => mh_get( 'mh_email' ),
		'address'     => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => '12 Place du Bois du Roy',
			'postalCode'      => '49240',
			'addressLocality' => 'Avrillé',
			'addressRegion'   => 'Pays de la Loire',
			'addressCountry'  => 'FR',
		),
		'areaServed'  => array( 'Angers', 'Avrillé', 'Maine-et-Loire' ),
		'priceRange'  => '65€ – 139€',
		'founder'     => array(
			'@type'    => 'Person',
			'name'     => mh_get( 'mh_practitioner' ),
			'jobTitle' => __( 'Hypnothérapeute', 'maxime-hypnose' ),
		),
		'openingHoursSpecification' => array(
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ),
				'opens'     => '10:00',
				'closes'    => '20:00',
			),
			array(
				'@type'     => 'OpeningHoursSpecification',
				'dayOfWeek' => array( 'Saturday' ),
				'opens'     => '10:00',
				'closes'    => '14:00',
			),
		),
	);

	mh_print_json_ld( $business );

	if ( ! is_singular( 'post' ) ) {
		return;
	}

	$article = array(
		'@context'      => 'https://schema.org',
		'@type'         => 'BlogPosting',
		'headline'      => wp_strip_all_tags( get_the_title() ),
		'datePublished' => get_the_date( 'c' ),
		'dateModified'  => get_the_modified_date( 'c' ),
		'author'        => array(
			'@type' => 'Person',
			'name'  => get_the_author(),
		),
		'publisher'     => array( '@id' => home_url( '/#cabinet' ) ),
		'mainEntityOfPage' => get_permalink(),
	);

	$thumb = get_the_post_thumbnail_url( null, 'mh-lead' );

	if ( $thumb ) {
		$article['image'] = $thumb;
	}

	mh_print_json_ld( $article );
}
add_action( 'wp_head', 'mh_structured_data', 20 );

/**
 * Écrit un bloc JSON-LD.
 *
 * @param array $data Données.
 */
function mh_print_json_ld( array $data ): void {
	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
	);
}

/**
 * Balises Open Graph minimales.
 */
function mh_social_meta(): void {
	$title       = is_front_page() ? get_bloginfo( 'name' ) : wp_strip_all_tags( mh_current_title() );
	$description = is_singular() ? wp_strip_all_tags( get_the_excerpt() ) : get_bloginfo( 'description' );
	$image       = is_singular() ? get_the_post_thumbnail_url( null, 'mh-lead' ) : '';
	?>
	<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
	<meta property="og:type" content="<?php echo is_singular( 'post' ) ? 'article' : 'website'; ?>">
	<meta property="og:locale" content="fr_FR">
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( wp_trim_words( (string) $description, 32 ) ); ?>">
	<meta property="og:url" content="<?php echo esc_url( is_singular() ? (string) get_permalink() : home_url( add_query_arg( array() ) ) ); ?>">
	<?php if ( $image ) : ?>
		<meta property="og:image" content="<?php echo esc_url( $image ); ?>">
	<?php endif; ?>
	<meta name="twitter:card" content="summary_large_image">
	<?php
}
add_action( 'wp_head', 'mh_social_meta', 5 );
