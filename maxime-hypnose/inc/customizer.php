<?php
/**
 * Réglages éditables depuis l'administration (coordonnées, réservation, réseaux).
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

/**
 * Valeurs par défaut du cabinet.
 *
 * @return array<string, string>
 */
function mh_defaults(): array {
	return array(
		'mh_practitioner' => 'Maxime Blanchard',
		'mh_phone'        => '06 51 09 29 18',
		'mh_email'        => 'contact@hypnose-angers-blanchard.com',
		'mh_address'      => '12 Place du Bois du Roy, 49240 Avrillé',
		'mh_hours_week'   => 'Lundi – vendredi : 10h – 20h',
		'mh_hours_sat'    => 'Samedi : 10h – 14h',
		'mh_booking_url'  => '/contact/',
		'mh_maps_url'     => 'https://www.google.com/maps/search/?api=1&query=12+Place+du+Bois+du+Roy+49240+Avrill%C3%A9',
	);
}

/**
 * Récupère un réglage avec repli sur la valeur par défaut.
 *
 * @param string $key Clé du réglage.
 * @return string
 */
function mh_get( string $key ): string {
	$defaults = mh_defaults();
	$default  = $defaults[ $key ] ?? '';

	return (string) get_theme_mod( $key, $default );
}

/**
 * Numéro de téléphone au format tel:.
 *
 * @return string
 */
function mh_phone_link(): string {
	$digits = preg_replace( '/[^0-9+]/', '', mh_get( 'mh_phone' ) );

	if ( str_starts_with( (string) $digits, '0' ) ) {
		$digits = '+33' . substr( (string) $digits, 1 );
	}

	return 'tel:' . $digits;
}

/**
 * Déclaration des champs du Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Gestionnaire.
 */
function mh_customize_register( WP_Customize_Manager $wp_customize ): void {
	$wp_customize->add_section(
		'mh_cabinet',
		array(
			'title'       => __( 'Cabinet — coordonnées', 'maxime-hypnose' ),
			'description' => __( 'Ces informations alimentent l\'en-tête, le pied de page, la page contact et les données structurées.', 'maxime-hypnose' ),
			'priority'    => 25,
		)
	);

	$fields = array(
		'mh_practitioner' => array( __( 'Nom du praticien', 'maxime-hypnose' ), 'sanitize_text_field' ),
		'mh_phone'        => array( __( 'Téléphone', 'maxime-hypnose' ), 'sanitize_text_field' ),
		'mh_email'        => array( __( 'Email', 'maxime-hypnose' ), 'sanitize_email' ),
		'mh_address'      => array( __( 'Adresse', 'maxime-hypnose' ), 'sanitize_text_field' ),
		'mh_hours_week'   => array( __( 'Horaires semaine', 'maxime-hypnose' ), 'sanitize_text_field' ),
		'mh_hours_sat'    => array( __( 'Horaires samedi', 'maxime-hypnose' ), 'sanitize_text_field' ),
		'mh_booking_url'  => array( __( 'Lien de prise de rendez-vous', 'maxime-hypnose' ), 'esc_url_raw' ),
		'mh_maps_url'     => array( __( 'Lien Google Maps', 'maxime-hypnose' ), 'esc_url_raw' ),
	);

	$defaults = mh_defaults();

	foreach ( $fields as $key => list( $label, $sanitize ) ) {
		$wp_customize->add_setting(
			$key,
			array(
				'default'           => $defaults[ $key ],
				'sanitize_callback' => $sanitize,
				'transport'         => 'refresh',
			)
		);

		$wp_customize->add_control(
			$key,
			array(
				'label'   => $label,
				'section' => 'mh_cabinet',
				'type'    => 'text',
			)
		);
	}
}
add_action( 'customize_register', 'mh_customize_register' );
