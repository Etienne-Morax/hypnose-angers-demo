<?php
/**
 * Témoignages.
 *
 * ATTENTION : contenu de démonstration. Ces trois témoignages sont des exemples
 * destinés à être remplacés par de vrais avis clients (Google, Doctolib, courriels
 * avec accord écrit) avant toute mise en ligne publique.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

$mh_quotes = array(
	array(
		'text'   => __( 'Exemple de témoignage à remplacer par un avis réel : décrire le motif de consultation, le déroulé et le résultat obtenu.', 'maxime-hypnose' ),
		'author' => __( 'Prénom N., Angers', 'maxime-hypnose' ),
		'topic'  => __( 'Arrêt du tabac', 'maxime-hypnose' ),
	),
	array(
		'text'   => __( 'Exemple de témoignage à remplacer par un avis réel : deux à trois phrases suffisent, en gardant les mots du client.', 'maxime-hypnose' ),
		'author' => __( 'Prénom N., Avrillé', 'maxime-hypnose' ),
		'topic'  => __( 'Sommeil', 'maxime-hypnose' ),
	),
	array(
		'text'   => __( 'Exemple de témoignage à remplacer par un avis réel : privilégier les retours concrets aux formules générales.', 'maxime-hypnose' ),
		'author' => __( 'Prénom N., Beaucouzé', 'maxime-hypnose' ),
		'topic'  => __( 'Stress', 'maxime-hypnose' ),
	),
);
?>
<section class="section section--tinted" id="temoignages">
	<div class="wrap">
		<div class="section__head reveal">
			<p class="eyebrow"><?php esc_html_e( 'Retours', 'maxime-hypnose' ); ?></p>
			<h2><?php esc_html_e( 'Ce qu\'en disent les personnes accompagnées', 'maxime-hypnose' ); ?></h2>
		</div>

		<div class="grid-pricing">
			<?php foreach ( $mh_quotes as $mh_quote ) : ?>
				<figure class="quote reveal">
					<div class="quote__stars" aria-hidden="true">
						<?php for ( $mh_i = 0; $mh_i < 5; $mh_i++ ) : ?>
							<?php mh_the_icon( 'star', 15 ); ?>
						<?php endfor; ?>
					</div>
					<blockquote><?php echo esc_html( $mh_quote['text'] ); ?></blockquote>
					<figcaption>
						<?php echo esc_html( $mh_quote['author'] ); ?> — <?php echo esc_html( $mh_quote['topic'] ); ?>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
