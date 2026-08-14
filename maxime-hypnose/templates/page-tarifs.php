<?php
/**
 * Template Name: Tarifs & infos pratiques
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="page-hero">
	<div class="wrap">
		<?php mh_breadcrumbs(); ?>
		<p class="eyebrow"><?php esc_html_e( 'Tarifs & infos pratiques', 'maxime-hypnose' ); ?></p>
		<h1><?php esc_html_e( 'Tout ce qu\'il faut savoir avant de venir', 'maxime-hypnose' ); ?></h1>
		<p class="lede"><?php esc_html_e( 'Tarifs, durées, règlement, accès et annulation : rien de caché, rien à découvrir sur place.', 'maxime-hypnose' ); ?></p>
	</div>
</section>

<?php get_template_part( 'template-parts/section', 'tarifs' ); ?>

<section class="section section--tinted">
	<div class="wrap grid-two">
		<div class="reveal">
			<p class="eyebrow"><?php esc_html_e( 'Infos pratiques', 'maxime-hypnose' ); ?></p>
			<h2><?php esc_html_e( 'Venir au cabinet', 'maxime-hypnose' ); ?></h2>
			<ul class="info-list">
				<li>
					<?php mh_the_icon( 'pin', 22 ); ?>
					<span>
						<strong><?php esc_html_e( 'Adresse', 'maxime-hypnose' ); ?></strong>
						<span><?php echo esc_html( mh_get( 'mh_address' ) ); ?></span>
					</span>
				</li>
				<li>
					<?php mh_the_icon( 'clock', 22 ); ?>
					<span>
						<strong><?php esc_html_e( 'Horaires', 'maxime-hypnose' ); ?></strong>
						<span><?php echo esc_html( mh_get( 'mh_hours_week' ) ); ?> · <?php echo esc_html( mh_get( 'mh_hours_sat' ) ); ?><br>
						<?php esc_html_e( 'Sur rendez-vous uniquement.', 'maxime-hypnose' ); ?></span>
					</span>
				</li>
				<li>
					<?php mh_the_icon( 'calendar', 22 ); ?>
					<span>
						<strong><?php esc_html_e( 'Annulation', 'maxime-hypnose' ); ?></strong>
						<span><?php esc_html_e( 'Prévenez au moins 24 h à l\'avance. Passé ce délai, la séance reste due sauf imprévu majeur.', 'maxime-hypnose' ); ?></span>
					</span>
				</li>
				<li>
					<?php mh_the_icon( 'shield', 22 ); ?>
					<span>
						<strong><?php esc_html_e( 'Règlement', 'maxime-hypnose' ); ?></strong>
						<span><?php esc_html_e( 'Espèces, chèque ou virement en fin de séance. Facture remise sur demande pour votre mutuelle.', 'maxime-hypnose' ); ?></span>
					</span>
				</li>
			</ul>

			<a class="btn btn--ghost" style="margin-top:var(--sp-5)"
				href="<?php echo esc_url( mh_get( 'mh_maps_url' ) ); ?>" target="_blank" rel="noopener noreferrer">
				<?php mh_the_icon( 'pin', 18 ); ?>
				<?php esc_html_e( 'Ouvrir l\'itinéraire', 'maxime-hypnose' ); ?>
			</a>
		</div>

		<div class="reveal">
			<div class="card card--feature">
				<h3><?php esc_html_e( 'Accès et stationnement', 'maxime-hypnose' ); ?></h3>
				<p><?php esc_html_e( 'Le cabinet se situe à Avrillé, à une dizaine de minutes du centre d\'Angers. Stationnement gratuit sur la place, devant le bâtiment.', 'maxime-hypnose' ); ?></p>
				<p><?php esc_html_e( 'Arrivez cinq minutes en avance : la séance démarre à l\'heure convenue et la durée annoncée est respectée.', 'maxime-hypnose' ); ?></p>
				<div class="badge-row" style="margin-top:var(--sp-4)">
					<span class="badge"><?php mh_the_icon( 'check', 16 ); ?><?php esc_html_e( 'Parking gratuit', 'maxime-hypnose' ); ?></span>
					<span class="badge"><?php mh_the_icon( 'check', 16 ); ?><?php esc_html_e( 'Bus à proximité', 'maxime-hypnose' ); ?></span>
					<span class="badge"><?php mh_the_icon( 'check', 16 ); ?><?php esc_html_e( 'Rez-de-chaussée', 'maxime-hypnose' ); ?></span>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/section', 'faq' );
get_template_part( 'template-parts/section', 'contact' );
get_footer();
