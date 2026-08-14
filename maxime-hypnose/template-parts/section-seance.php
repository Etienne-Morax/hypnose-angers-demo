<?php
/**
 * Déroulé d'une séance.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

$mh_steps = array(
	array(
		'title' => __( 'L\'échange', 'maxime-hypnose' ),
		'text'  => __( 'On pose votre situation, ce que vous avez déjà tenté, et l\'objectif concret. Rien n\'est standardisé : la séance se construit à partir de là.', 'maxime-hypnose' ),
	),
	array(
		'title' => __( 'La séance d\'hypnose', 'maxime-hypnose' ),
		'text'  => __( 'Assis ou allongé, conscient, libre de vos mouvements. Je guide votre attention, vous restez aux commandes du début à la fin.', 'maxime-hypnose' ),
	),
	array(
		'title' => __( 'Les outils', 'maxime-hypnose' ),
		'text'  => __( 'Vous repartez avec deux ou trois techniques simples, à réutiliser dès que la situation se présente à nouveau.', 'maxime-hypnose' ),
	),
	array(
		'title' => __( 'Le suivi', 'maxime-hypnose' ),
		'text'  => __( 'Beaucoup n\'ont besoin que d\'une séance. Si une suite est utile, on la planifie ensemble — jamais par principe.', 'maxime-hypnose' ),
	),
);
?>
<section class="section section--inverse" id="deroule">
	<div class="wrap">
		<div class="section__head reveal">
			<p class="eyebrow"><?php esc_html_e( 'Déroulé', 'maxime-hypnose' ); ?></p>
			<h2><?php esc_html_e( 'Une séance, quatre temps', 'maxime-hypnose' ); ?></h2>
			<p class="lede"><?php esc_html_e( 'Comptez 1h15 pour un adulte, 1h30 pour une première séance d\'arrêt du tabac.', 'maxime-hypnose' ); ?></p>
		</div>

		<div class="steps">
			<?php foreach ( $mh_steps as $mh_step ) : ?>
				<article class="step reveal">
					<h3><?php echo esc_html( $mh_step['title'] ); ?></h3>
					<p><?php echo esc_html( $mh_step['text'] ); ?></p>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
