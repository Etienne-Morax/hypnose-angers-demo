<?php
/**
 * Domaines d'application.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

$mh_domains = array(
	array(
		'icon'  => 'sparkles',
		'title' => __( 'Hypersensibilité', 'maxime-hypnose' ),
		'text'  => __( 'Émotions qui débordent, fatigue sociale, réactions disproportionnées. On travaille le filtre, pas la sensibilité elle-même — elle reste une force.', 'maxime-hypnose' ),
		'lead'  => true,
	),
	array(
		'icon'  => 'cigarette',
		'title' => __( 'Arrêt du tabac', 'maxime-hypnose' ),
		'text'  => __( 'Une séance longue et structurée, sans substitut ni volonté héroïque.', 'maxime-hypnose' ),
	),
	array(
		'icon'  => 'moon',
		'title' => __( 'Troubles du sommeil', 'maxime-hypnose' ),
		'text'  => __( 'Endormissement, réveils nocturnes, mental qui tourne au moment du coucher.', 'maxime-hypnose' ),
	),
	array(
		'icon'  => 'wind',
		'title' => __( 'Stress et anxiété', 'maxime-hypnose' ),
		'text'  => __( 'Anticipation, tension permanente, crises d\'angoisse.', 'maxime-hypnose' ),
	),
	array(
		'icon'  => 'heart',
		'title' => __( 'Peurs et phobies', 'maxime-hypnose' ),
		'text'  => __( 'Avion, conduite, animaux, prise de parole, milieux médicaux.', 'maxime-hypnose' ),
	),
	array(
		'icon'  => 'utensils',
		'title' => __( 'Troubles alimentaires', 'maxime-hypnose' ),
		'text'  => __( 'Compulsions, grignotage émotionnel, rapport au corps.', 'maxime-hypnose' ),
	),
	array(
		'icon'  => 'shield',
		'title' => __( 'Confiance en soi', 'maxime-hypnose' ),
		'text'  => __( 'Estime, syndrome de l\'imposteur, blocages avant un examen ou un entretien.', 'maxime-hypnose' ),
	),
);
?>
<section class="section" id="domaines">
	<div class="wrap">
		<div class="section__head section__head--split reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Domaines d\'application', 'maxime-hypnose' ); ?></p>
				<h2><?php esc_html_e( 'Ce pour quoi on vient me voir', 'maxime-hypnose' ); ?></h2>
			</div>
			<p class="lede">
				<?php esc_html_e( 'Dépendances, TOC, tics, douleurs, problèmes de peau, allergies, difficultés de conception : la liste n\'est pas fermée. Si votre motif n\'y figure pas, appelez, on regarde ensemble.', 'maxime-hypnose' ); ?>
			</p>
		</div>

		<div class="grid-domains">
			<?php foreach ( $mh_domains as $mh_domain ) : ?>
				<article class="card reveal<?php echo ! empty( $mh_domain['lead'] ) ? ' card--feature' : ''; ?>">
					<span class="card__icon"><?php mh_the_icon( $mh_domain['icon'], 22 ); ?></span>
					<h3><?php echo esc_html( $mh_domain['title'] ); ?></h3>
					<p><?php echo esc_html( $mh_domain['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
