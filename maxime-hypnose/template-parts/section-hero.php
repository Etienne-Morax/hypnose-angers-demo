<?php
/**
 * Héros de la page d'accueil.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="hero">
	<div class="wrap hero__grid">
		<div class="hero__content">
			<p class="eyebrow"><?php esc_html_e( 'Cabinet d\'hypnose · Avrillé — Angers', 'maxime-hypnose' ); ?></p>

			<h1 class="hero__title">
				<?php esc_html_e( 'Reprendre la main sur', 'maxime-hypnose' ); ?>
				<em><?php esc_html_e( 'ce qui vous échappe', 'maxime-hypnose' ); ?></em>
			</h1>

			<p class="lede hero__lede">
				<?php esc_html_e( 'Tabac, sommeil, stress, phobies, hypersensibilité. Une hypnose moderne où vous restez conscient et acteur — et où vous repartez avec des outils réutilisables seul.', 'maxime-hypnose' ); ?>
			</p>

			<div class="hero__actions">
				<a class="btn btn--primary" href="<?php echo esc_url( mh_get( 'mh_booking_url' ) ); ?>">
					<?php esc_html_e( 'Prendre rendez-vous', 'maxime-hypnose' ); ?>
					<?php mh_the_icon( 'arrow-right', 18 ); ?>
				</a>
				<a class="btn btn--ghost" href="#deroule">
					<?php esc_html_e( 'Comment se passe une séance', 'maxime-hypnose' ); ?>
				</a>
			</div>

			<div class="hero__proof">
				<div class="proof-item">
					<span class="proof-item__value"><?php esc_html_e( 'Depuis 2013', 'maxime-hypnose' ); ?></span>
					<span class="proof-item__label"><?php esc_html_e( 'Diplômé de l\'IFTR, formateur en hypnose', 'maxime-hypnose' ); ?></span>
				</div>
				<div class="proof-item">
					<span class="proof-item__value"><?php esc_html_e( '1 à 3 séances', 'maxime-hypnose' ); ?></span>
					<span class="proof-item__label"><?php esc_html_e( 'Suffisent pour la majorité des motifs', 'maxime-hypnose' ); ?></span>
				</div>
				<div class="proof-item">
					<span class="proof-item__value"><?php esc_html_e( '6 j / 7', 'maxime-hypnose' ); ?></span>
					<span class="proof-item__label"><?php esc_html_e( 'Créneaux jusqu\'à 20h en semaine', 'maxime-hypnose' ); ?></span>
				</div>
			</div>
		</div>

		<div class="hero__visual">
			<?php mh_hero_visual(); ?>
			<div class="hero__card">
				<?php mh_the_icon( 'leaf', 22 ); ?>
				<span><?php esc_html_e( 'Vous restez conscient, libre de parler et de bouger pendant toute la séance.', 'maxime-hypnose' ); ?></span>
			</div>
		</div>
	</div>
</section>
