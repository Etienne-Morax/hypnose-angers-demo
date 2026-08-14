<?php
/**
 * Tarifs.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

$mh_prices = array(
	array(
		'name'     => __( 'Séance jeune public', 'maxime-hypnose' ),
		'amount'   => '65',
		'meta'     => __( 'Moins de 15 ans · 1 h', 'maxime-hypnose' ),
		'features' => array(
			__( 'Temps d\'échange avec le parent accompagnant', 'maxime-hypnose' ),
			__( 'Format et vocabulaire adaptés à l\'âge', 'maxime-hypnose' ),
			__( 'Sommeil, angoisses, énurésie, confiance', 'maxime-hypnose' ),
		),
	),
	array(
		'name'     => __( 'Séance adulte', 'maxime-hypnose' ),
		'amount'   => '79',
		'meta'     => __( 'À partir de 15 ans · 1 h 15', 'maxime-hypnose' ),
		'tag'      => __( 'Le plus demandé', 'maxime-hypnose' ),
		'featured' => true,
		'features' => array(
			__( 'Échange préalable et objectif défini ensemble', 'maxime-hypnose' ),
			__( 'Séance d\'hypnose personnalisée', 'maxime-hypnose' ),
			__( 'Outils d\'autohypnose à réutiliser seul', 'maxime-hypnose' ),
		),
	),
	array(
		'name'     => __( 'Arrêt du tabac', 'maxime-hypnose' ),
		'amount'   => '139',
		'meta'     => __( 'Première séance · 1 h 30', 'maxime-hypnose' ),
		'features' => array(
			__( 'Protocole long et structuré', 'maxime-hypnose' ),
			__( 'Gestion du manque et des situations à risque', 'maxime-hypnose' ),
			__( 'Séance de renforcement au tarif adulte si besoin', 'maxime-hypnose' ),
		),
	),
);
?>
<section class="section" id="tarifs">
	<div class="wrap">
		<div class="section__head section__head--split reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Tarifs', 'maxime-hypnose' ); ?></p>
				<h2><?php esc_html_e( 'Des tarifs annoncés, sans forfait imposé', 'maxime-hypnose' ); ?></h2>
			</div>
			<p class="lede">
				<?php esc_html_e( 'Règlement en espèces, chèque ou virement à la fin de la séance. Séance non remboursée par la Sécurité sociale, certaines mutuelles participent.', 'maxime-hypnose' ); ?>
			</p>
		</div>

		<div class="grid-pricing">
			<?php foreach ( $mh_prices as $mh_price ) : ?>
				<article class="price-card reveal<?php echo ! empty( $mh_price['featured'] ) ? ' price-card--featured' : ''; ?>">
					<?php if ( ! empty( $mh_price['tag'] ) ) : ?>
						<span class="price-card__tag"><?php echo esc_html( $mh_price['tag'] ); ?></span>
					<?php endif; ?>

					<h3 class="price-card__name"><?php echo esc_html( $mh_price['name'] ); ?></h3>
					<p class="price-card__amount"><?php echo esc_html( $mh_price['amount'] ); ?><span> €</span></p>
					<p class="price-card__meta"><?php echo esc_html( $mh_price['meta'] ); ?></p>

					<ul>
						<?php foreach ( $mh_price['features'] as $mh_feature ) : ?>
							<li><?php mh_the_icon( 'check', 18 ); ?><span><?php echo esc_html( $mh_feature ); ?></span></li>
						<?php endforeach; ?>
					</ul>

					<a class="btn <?php echo ! empty( $mh_price['featured'] ) ? 'btn--primary' : 'btn--ghost'; ?>"
						href="<?php echo esc_url( mh_get( 'mh_booking_url' ) ); ?>">
						<?php esc_html_e( 'Réserver ce créneau', 'maxime-hypnose' ); ?>
					</a>
				</article>
			<?php endforeach; ?>
		</div>

		<p class="field__hint" style="margin-top:var(--sp-5)">
			<?php esc_html_e( 'Rendez-vous annulé moins de 24 h à l\'avance : la séance reste due, sauf imprévu majeur.', 'maxime-hypnose' ); ?>
		</p>
	</div>
</section>
