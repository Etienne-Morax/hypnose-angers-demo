<?php
/**
 * Template Name: Contact & rendez-vous
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

get_header();

$mh_form   = mh_form_state();
$mh_values = $mh_form['values'];
$mh_errors = $mh_form['errors'];
?>

<section class="page-hero">
	<div class="wrap">
		<?php mh_breadcrumbs(); ?>
		<p class="eyebrow"><?php esc_html_e( 'Contact', 'maxime-hypnose' ); ?></p>
		<h1><?php esc_html_e( 'Prendre rendez-vous', 'maxime-hypnose' ); ?></h1>
		<p class="lede">
			<?php esc_html_e( 'Le plus simple reste l\'appel : on vérifie en quelques minutes que l\'hypnose correspond à votre situation. Sinon, écrivez-moi, je réponds sous 24 à 48 heures ouvrées.', 'maxime-hypnose' ); ?>
		</p>
	</div>
</section>

<section class="section">
	<div class="wrap grid-two" style="align-items:start">
		<div class="reveal">
			<h2><?php esc_html_e( 'Écrire un message', 'maxime-hypnose' ); ?></h2>

			<?php if ( '' !== $mh_form['status'] ) : ?>
				<p class="notice<?php echo 'error' === $mh_form['status'] ? ' notice--error' : ''; ?>"
					role="<?php echo 'error' === $mh_form['status'] ? 'alert' : 'status'; ?>" aria-live="polite">
					<?php echo esc_html( $mh_form['message'] ); ?>
				</p>
			<?php endif; ?>

			<form class="form" method="post" action="<?php echo esc_url( get_permalink() ); ?>#main" novalidate>
				<?php wp_nonce_field( MH_FORM_ACTION, 'mh_contact_nonce' ); ?>

				<p class="honeypot" aria-hidden="true">
					<label for="mh_website"><?php esc_html_e( 'Ne pas remplir', 'maxime-hypnose' ); ?></label>
					<input type="text" id="mh_website" name="mh_website" tabindex="-1" autocomplete="off">
				</p>

				<div class="form__row">
					<div class="field">
						<label for="mh_name"><?php esc_html_e( 'Nom', 'maxime-hypnose' ); ?> <span class="req">*</span></label>
						<input type="text" id="mh_name" name="mh_name" autocomplete="name" required
							value="<?php echo esc_attr( $mh_values['name'] ); ?>"
							<?php echo isset( $mh_errors['name'] ) ? 'aria-invalid="true" aria-describedby="err-name"' : ''; ?>>
						<?php if ( isset( $mh_errors['name'] ) ) : ?>
							<span class="field__error" id="err-name"><?php echo esc_html( $mh_errors['name'] ); ?></span>
						<?php endif; ?>
					</div>

					<div class="field">
						<label for="mh_email"><?php esc_html_e( 'Email', 'maxime-hypnose' ); ?> <span class="req">*</span></label>
						<input type="email" id="mh_email" name="mh_email" autocomplete="email" required
							value="<?php echo esc_attr( $mh_values['email'] ); ?>"
							<?php echo isset( $mh_errors['email'] ) ? 'aria-invalid="true" aria-describedby="err-email"' : ''; ?>>
						<?php if ( isset( $mh_errors['email'] ) ) : ?>
							<span class="field__error" id="err-email"><?php echo esc_html( $mh_errors['email'] ); ?></span>
						<?php endif; ?>
					</div>
				</div>

				<div class="form__row">
					<div class="field">
						<label for="mh_phone"><?php esc_html_e( 'Téléphone', 'maxime-hypnose' ); ?></label>
						<input type="tel" id="mh_phone" name="mh_phone" autocomplete="tel" inputmode="tel"
							value="<?php echo esc_attr( $mh_values['phone'] ); ?>">
						<span class="field__hint"><?php esc_html_e( 'Facultatif — utile si vous préférez être rappelé.', 'maxime-hypnose' ); ?></span>
					</div>

					<div class="field">
						<label for="mh_subject"><?php esc_html_e( 'Motif', 'maxime-hypnose' ); ?></label>
						<select id="mh_subject" name="mh_subject">
							<?php
							$mh_subjects = array(
								'',
								__( 'Arrêt du tabac', 'maxime-hypnose' ),
								__( 'Sommeil', 'maxime-hypnose' ),
								__( 'Stress, anxiété', 'maxime-hypnose' ),
								__( 'Peurs et phobies', 'maxime-hypnose' ),
								__( 'Troubles alimentaires', 'maxime-hypnose' ),
								__( 'Confiance en soi', 'maxime-hypnose' ),
								__( 'Autre / je ne sais pas', 'maxime-hypnose' ),
							);
							foreach ( $mh_subjects as $mh_subject ) :
								?>
								<option value="<?php echo esc_attr( $mh_subject ); ?>" <?php selected( $mh_values['subject'], $mh_subject ); ?>>
									<?php echo '' === $mh_subject ? esc_html__( 'Choisir…', 'maxime-hypnose' ) : esc_html( $mh_subject ); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="field">
					<label for="mh_message"><?php esc_html_e( 'Votre message', 'maxime-hypnose' ); ?> <span class="req">*</span></label>
					<textarea id="mh_message" name="mh_message" required
						<?php echo isset( $mh_errors['message'] ) ? 'aria-invalid="true" aria-describedby="err-message"' : ''; ?>><?php echo esc_textarea( $mh_values['message'] ); ?></textarea>
					<?php if ( isset( $mh_errors['message'] ) ) : ?>
						<span class="field__error" id="err-message"><?php echo esc_html( $mh_errors['message'] ); ?></span>
					<?php else : ?>
						<span class="field__hint"><?php esc_html_e( 'Quelques lignes suffisent : votre situation, ce que vous avez déjà essayé, vos disponibilités.', 'maxime-hypnose' ); ?></span>
					<?php endif; ?>
				</div>

				<button class="btn btn--primary" type="submit">
					<?php esc_html_e( 'Envoyer le message', 'maxime-hypnose' ); ?>
					<?php mh_the_icon( 'arrow-right', 18 ); ?>
				</button>

				<p class="field__hint">
					<?php esc_html_e( 'Vos informations servent uniquement à répondre à votre demande. Elles ne sont ni revendues ni utilisées à des fins commerciales.', 'maxime-hypnose' ); ?>
				</p>
			</form>
		</div>

		<div class="reveal">
			<div class="card card--feature">
				<h3><?php esc_html_e( 'Contact direct', 'maxime-hypnose' ); ?></h3>
				<ul class="info-list" style="margin-top:var(--sp-4)">
					<li><?php mh_the_icon( 'phone', 20 ); ?><span><strong><?php esc_html_e( 'Téléphone', 'maxime-hypnose' ); ?></strong><span><a href="<?php echo esc_url( mh_phone_link() ); ?>"><?php echo esc_html( mh_get( 'mh_phone' ) ); ?></a></span></span></li>
					<li><?php mh_the_icon( 'mail', 20 ); ?><span><strong><?php esc_html_e( 'Email', 'maxime-hypnose' ); ?></strong><span><a href="mailto:<?php echo esc_attr( mh_get( 'mh_email' ) ); ?>"><?php echo esc_html( mh_get( 'mh_email' ) ); ?></a></span></span></li>
					<li><?php mh_the_icon( 'pin', 20 ); ?><span><strong><?php esc_html_e( 'Cabinet', 'maxime-hypnose' ); ?></strong><span><?php echo esc_html( mh_get( 'mh_address' ) ); ?></span></span></li>
					<li><?php mh_the_icon( 'clock', 20 ); ?><span><strong><?php esc_html_e( 'Horaires', 'maxime-hypnose' ); ?></strong><span><?php echo esc_html( mh_get( 'mh_hours_week' ) ); ?><br><?php echo esc_html( mh_get( 'mh_hours_sat' ) ); ?></span></span></li>
				</ul>

				<a class="btn btn--ghost" style="margin-top:var(--sp-5)"
					href="<?php echo esc_url( mh_get( 'mh_maps_url' ) ); ?>" target="_blank" rel="noopener noreferrer">
					<?php mh_the_icon( 'pin', 18 ); ?>
					<?php esc_html_e( 'Voir sur la carte', 'maxime-hypnose' ); ?>
				</a>
			</div>

			<div class="notice" style="margin-top:var(--sp-5)">
				<strong><?php esc_html_e( 'Urgence.', 'maxime-hypnose' ); ?></strong>
				<?php esc_html_e( 'En cas de détresse immédiate, contactez le 15, le 112, ou le 3114 (prévention du suicide, gratuit, 24h/24).', 'maxime-hypnose' ); ?>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
