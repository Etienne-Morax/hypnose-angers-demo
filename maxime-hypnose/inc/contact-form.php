<?php
/**
 * Formulaire de contact : traitement côté serveur, nonce, pot de miel, limitation.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

const MH_FORM_ACTION    = 'mh_contact_submit';
const MH_RATE_LIMIT_SEC = 60;

/**
 * État courant du formulaire (résultat + valeurs saisies).
 *
 * @return array{status:string, message:string, errors:array<string,string>, values:array<string,string>}
 */
function mh_form_state(): array {
	static $state = null;

	if ( null !== $state ) {
		return $state;
	}

	$state = array(
		'status'   => '',
		'message'  => '',
		'errors'   => array(),
		'values'   => array(
			'name'    => '',
			'email'   => '',
			'phone'   => '',
			'subject' => '',
			'message' => '',
		),
	);

	if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) || ! isset( $_POST['mh_contact_nonce'] ) ) {
		return $state;
	}

	$nonce = sanitize_text_field( wp_unslash( $_POST['mh_contact_nonce'] ) );

	if ( ! wp_verify_nonce( $nonce, MH_FORM_ACTION ) ) {
		$state['status']  = 'error';
		$state['message'] = __( 'Votre session a expiré. Merci de renvoyer le message.', 'maxime-hypnose' );

		return $state;
	}

	// Pot de miel : rempli uniquement par les robots.
	if ( ! empty( $_POST['mh_website'] ) ) {
		$state['status']  = 'success';
		$state['message'] = __( 'Message envoyé.', 'maxime-hypnose' );

		return $state;
	}

	$ip_key = 'mh_rl_' . md5( (string) ( $_SERVER['REMOTE_ADDR'] ?? '' ) );

	if ( get_transient( $ip_key ) ) {
		$state['status']  = 'error';
		$state['message'] = __( 'Un message vient déjà d\'être envoyé. Merci de patienter une minute.', 'maxime-hypnose' );

		return $state;
	}

	$values = array(
		'name'    => sanitize_text_field( wp_unslash( $_POST['mh_name'] ?? '' ) ),
		'email'   => sanitize_email( wp_unslash( $_POST['mh_email'] ?? '' ) ),
		'phone'   => sanitize_text_field( wp_unslash( $_POST['mh_phone'] ?? '' ) ),
		'subject' => sanitize_text_field( wp_unslash( $_POST['mh_subject'] ?? '' ) ),
		'message' => sanitize_textarea_field( wp_unslash( $_POST['mh_message'] ?? '' ) ),
	);

	$state['values'] = $values;
	$errors          = array();

	if ( '' === $values['name'] ) {
		$errors['name'] = __( 'Merci d\'indiquer votre nom.', 'maxime-hypnose' );
	}

	if ( ! is_email( $values['email'] ) ) {
		$errors['email'] = __( 'Cette adresse email semble incorrecte.', 'maxime-hypnose' );
	}

	if ( mb_strlen( $values['message'] ) < 10 ) {
		$errors['message'] = __( 'Merci de détailler votre demande en quelques mots (10 caractères minimum).', 'maxime-hypnose' );
	}

	if ( ! empty( $errors ) ) {
		$state['status']  = 'error';
		$state['errors']  = $errors;
		$state['message'] = __( 'Le formulaire contient des erreurs. Vérifiez les champs signalés ci-dessous.', 'maxime-hypnose' );

		return $state;
	}

	$sent = mh_send_contact_mail( $values );

	if ( $sent ) {
		set_transient( $ip_key, 1, MH_RATE_LIMIT_SEC );

		$state['status']  = 'success';
		$state['message'] = __( 'Merci, votre message est bien parti. Réponse sous 24 à 48 heures ouvrées.', 'maxime-hypnose' );
		$state['values']  = array_map( static fn() => '', $values );
	} else {
		$state['status']  = 'error';
		$state['message'] = sprintf(
			/* translators: %s: phone number. */
			__( 'L\'envoi a échoué. Vous pouvez appeler directement le %s.', 'maxime-hypnose' ),
			mh_get( 'mh_phone' )
		);
	}

	return $state;
}

/**
 * Envoie le message au cabinet.
 *
 * @param array<string,string> $values Champs validés.
 * @return bool
 */
function mh_send_contact_mail( array $values ): bool {
	$to      = mh_get( 'mh_email' );
	$subject = sprintf(
		/* translators: %s: sender name. */
		__( '[Site] Demande de %s', 'maxime-hypnose' ),
		$values['name']
	);

	$lines = array(
		__( 'Nom', 'maxime-hypnose' ) . ' : ' . $values['name'],
		__( 'Email', 'maxime-hypnose' ) . ' : ' . $values['email'],
		__( 'Téléphone', 'maxime-hypnose' ) . ' : ' . ( $values['phone'] ?: '—' ),
		__( 'Motif', 'maxime-hypnose' ) . ' : ' . ( $values['subject'] ?: '—' ),
		'',
		$values['message'],
	);

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $values['name'] . ' <' . $values['email'] . '>',
	);

	return wp_mail( $to, $subject, implode( "\n", $lines ), $headers );
}
