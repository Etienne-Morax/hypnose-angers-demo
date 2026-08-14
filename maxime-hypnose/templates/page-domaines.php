<?php
/**
 * Template Name: Domaines d'application
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

get_header();

$mh_areas = array(
	array(
		'icon'  => 'cigarette',
		'title' => __( 'Dépendances', 'maxime-hypnose' ),
		'text'  => __( 'Tabac, alcool, écrans, jeu. On travaille le déclencheur et le bénéfice caché du comportement, pas seulement le geste.', 'maxime-hypnose' ),
	),
	array(
		'icon'  => 'moon',
		'title' => __( 'Sommeil', 'maxime-hypnose' ),
		'text'  => __( 'Difficultés d\'endormissement, réveils à heure fixe, ruminations nocturnes, sommeil non réparateur.', 'maxime-hypnose' ),
	),
	array(
		'icon'  => 'wind',
		'title' => __( 'Stress et anxiété', 'maxime-hypnose' ),
		'text'  => __( 'Anxiété d\'anticipation, tension corporelle chronique, crises d\'angoisse, charge mentale.', 'maxime-hypnose' ),
	),
	array(
		'icon'  => 'utensils',
		'title' => __( 'Troubles alimentaires', 'maxime-hypnose' ),
		'text'  => __( 'Compulsions, grignotage émotionnel, restriction, rapport conflictuel au corps.', 'maxime-hypnose' ),
	),
	array(
		'icon'  => 'heart',
		'title' => __( 'Peurs et phobies', 'maxime-hypnose' ),
		'text'  => __( 'Avion, conduite, foule, animaux, sang, soins dentaires, prise de parole en public.', 'maxime-hypnose' ),
	),
	array(
		'icon'  => 'sparkles',
		'title' => __( 'Hypersensibilité', 'maxime-hypnose' ),
		'text'  => __( 'Saturation sensorielle, absorption des émotions des autres, épuisement après les interactions.', 'maxime-hypnose' ),
	),
	array(
		'icon'  => 'shield',
		'title' => __( 'Confiance en soi', 'maxime-hypnose' ),
		'text'  => __( 'Estime, image de soi, blocages professionnels, préparation d\'examen ou de compétition.', 'maxime-hypnose' ),
	),
	array(
		'icon'  => 'leaf',
		'title' => __( 'Autres accompagnements', 'maxime-hypnose' ),
		'text'  => __( 'TOC, tics, bruxisme, douleurs chroniques, problèmes de peau, allergies, difficultés de conception.', 'maxime-hypnose' ),
	),
);
?>

<section class="page-hero">
	<div class="wrap">
		<?php mh_breadcrumbs(); ?>
		<p class="eyebrow"><?php esc_html_e( 'Domaines d\'application', 'maxime-hypnose' ); ?></p>
		<h1><?php esc_html_e( 'Pour quoi consulter en hypnose', 'maxime-hypnose' ); ?></h1>
		<p class="lede">
			<?php esc_html_e( 'Cette liste couvre l\'essentiel des demandes reçues au cabinet. Elle n\'est pas limitative : en cas de doute, un appel suffit à savoir si je peux vous aider.', 'maxime-hypnose' ); ?>
		</p>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<div class="grid-domains">
			<?php foreach ( $mh_areas as $mh_area ) : ?>
				<article class="card reveal">
					<span class="card__icon"><?php mh_the_icon( $mh_area['icon'], 22 ); ?></span>
					<h3><?php echo esc_html( $mh_area['title'] ); ?></h3>
					<p><?php echo esc_html( $mh_area['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>

		<div class="notice" style="margin-top:var(--sp-7);max-width:52rem">
			<strong><?php esc_html_e( 'Limites de l\'accompagnement.', 'maxime-hypnose' ); ?></strong>
			<?php esc_html_e( 'L\'hypnose ne traite pas les pathologies psychiatriques et ne remplace aucun suivi médical. Si votre situation relève d\'une prise en charge médicale, je vous le dis et vous oriente.', 'maxime-hypnose' ); ?>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/section', 'tarifs' );
get_template_part( 'template-parts/section', 'contact' );
get_footer();
