<?php
/**
 * Questions fréquentes.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

$mh_faq = array(
	array(
		'q' => __( 'Est-ce que je vais dormir ou perdre conscience ?', 'maxime-hypnose' ),
		'a' => __( 'Non. L\'état d\'hypnose ressemble à celui où l\'on est absorbé par un film ou la route. Vous entendez tout, vous pouvez parler et interrompre la séance quand vous le souhaitez.', 'maxime-hypnose' ),
	),
	array(
		'q' => __( 'Combien de séances faut-il prévoir ?', 'maxime-hypnose' ),
		'a' => __( 'Pour la majorité des motifs, une à trois séances suffisent. L\'objectif est que vous n\'ayez plus besoin de revenir : les outils transmis servent après.', 'maxime-hypnose' ),
	),
	array(
		'q' => __( 'Tout le monde est-il réceptif ?', 'maxime-hypnose' ),
		'a' => __( 'Oui, à des degrés variables. La profondeur de l\'état n\'est pas ce qui détermine le résultat : la clarté de l\'objectif et votre implication comptent davantage.', 'maxime-hypnose' ),
	),
	array(
		'q' => __( 'La séance est-elle remboursée ?', 'maxime-hypnose' ),
		'a' => __( 'Pas par la Sécurité sociale. Certaines mutuelles proposent un forfait « médecines douces » : une facture vous est remise sur demande.', 'maxime-hypnose' ),
	),
	array(
		'q' => __( 'Puis-je consulter pour mon enfant ?', 'maxime-hypnose' ),
		'a' => __( 'Oui, à partir de 6 ans environ, avec un tarif et un format dédiés. Le parent est présent pour l\'échange initial.', 'maxime-hypnose' ),
	),
	array(
		'q' => __( 'L\'hypnose remplace-t-elle un traitement médical ?', 'maxime-hypnose' ),
		'a' => __( 'Jamais. L\'accompagnement est complémentaire d\'un suivi médical ou psychologique et ne se substitue à aucune prescription. N\'arrêtez aucun traitement sans avis de votre médecin.', 'maxime-hypnose' ),
	),
);
?>
<section class="section section--tinted" id="faq">
	<div class="wrap">
		<div class="section__head reveal">
			<p class="eyebrow"><?php esc_html_e( 'Questions fréquentes', 'maxime-hypnose' ); ?></p>
			<h2><?php esc_html_e( 'Ce qu\'on me demande avant de prendre rendez-vous', 'maxime-hypnose' ); ?></h2>
		</div>

		<div class="faq">
			<?php foreach ( $mh_faq as $mh_index => $mh_item ) : ?>
				<details class="faq__item reveal"<?php echo 0 === $mh_index ? ' open' : ''; ?>>
					<summary class="faq__question"><?php echo esc_html( $mh_item['q'] ); ?></summary>
					<div class="faq__answer"><p><?php echo esc_html( $mh_item['a'] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php
$mh_schema = array(
	'@context'   => 'https://schema.org',
	'@type'      => 'FAQPage',
	'mainEntity' => array_map(
		static function ( array $item ): array {
			return array(
				'@type'          => 'Question',
				'name'           => $item['q'],
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => $item['a'],
				),
			);
		},
		$mh_faq
	),
);

mh_print_json_ld( $mh_schema );
