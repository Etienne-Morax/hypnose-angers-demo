<?php
/**
 * Bandeau de contact en fin de page d'accueil.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--inverse" id="contact">
	<div class="wrap grid-two">
		<div class="reveal">
			<p class="eyebrow"><?php esc_html_e( 'Prendre rendez-vous', 'maxime-hypnose' ); ?></p>
			<h2><?php esc_html_e( 'Un doute sur votre situation ? Appelez, on en parle.', 'maxime-hypnose' ); ?></h2>
			<p class="lede">
				<?php esc_html_e( 'Le premier échange téléphonique est gratuit et sans engagement. Il sert à vérifier que l\'hypnose est la bonne approche pour vous.', 'maxime-hypnose' ); ?>
			</p>

			<div class="hero__actions" style="margin-top:var(--sp-6)">
				<a class="btn btn--light" href="<?php echo esc_url( mh_phone_link() ); ?>">
					<?php mh_the_icon( 'phone', 18 ); ?>
					<?php echo esc_html( mh_get( 'mh_phone' ) ); ?>
				</a>
				<a class="btn btn--ghost" style="border-color:rgba(255,255,255,.35);color:inherit"
					href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">
					<?php esc_html_e( 'Écrire un message', 'maxime-hypnose' ); ?>
				</a>
			</div>
		</div>

		<div class="reveal">
			<ul class="info-list">
				<li>
					<?php mh_the_icon( 'pin', 22 ); ?>
					<span>
						<strong><?php esc_html_e( 'Le cabinet', 'maxime-hypnose' ); ?></strong>
						<span><?php echo esc_html( mh_get( 'mh_address' ) ); ?><br>
						<?php esc_html_e( 'Stationnement gratuit devant le cabinet · 10 min du centre d\'Angers', 'maxime-hypnose' ); ?></span>
					</span>
				</li>
				<li>
					<?php mh_the_icon( 'clock', 22 ); ?>
					<span>
						<strong><?php esc_html_e( 'Horaires', 'maxime-hypnose' ); ?></strong>
						<span><?php echo esc_html( mh_get( 'mh_hours_week' ) ); ?><br>
						<?php echo esc_html( mh_get( 'mh_hours_sat' ) ); ?></span>
					</span>
				</li>
				<li>
					<?php mh_the_icon( 'mail', 22 ); ?>
					<span>
						<strong><?php esc_html_e( 'Email', 'maxime-hypnose' ); ?></strong>
						<span><a href="mailto:<?php echo esc_attr( mh_get( 'mh_email' ) ); ?>"><?php echo esc_html( mh_get( 'mh_email' ) ); ?></a></span>
					</span>
				</li>
			</ul>
		</div>
	</div>
</section>
