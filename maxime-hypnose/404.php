<?php
/**
 * Page introuvable.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="section">
	<div class="wrap wrap--narrow" style="text-align:center">
		<p class="eyebrow" style="justify-content:center"><?php esc_html_e( 'Erreur 404', 'maxime-hypnose' ); ?></p>
		<h1><?php esc_html_e( 'Cette page n\'existe pas ou a été déplacée', 'maxime-hypnose' ); ?></h1>
		<p class="lede" style="margin-inline:auto">
			<?php esc_html_e( 'Le plus rapide reste de revenir à l\'accueil, ou d\'appeler directement le cabinet.', 'maxime-hypnose' ); ?>
		</p>

		<div class="hero__actions" style="justify-content:center;margin-top:var(--sp-6)">
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Retour à l\'accueil', 'maxime-hypnose' ); ?>
			</a>
			<a class="btn btn--ghost" href="<?php echo esc_url( mh_phone_link() ); ?>">
				<?php mh_the_icon( 'phone', 18 ); ?>
				<?php echo esc_html( mh_get( 'mh_phone' ) ); ?>
			</a>
		</div>

		<div style="max-width:26rem;margin:var(--sp-7) auto 0"><?php get_search_form(); ?></div>
	</div>
</section>

<?php
get_footer();
