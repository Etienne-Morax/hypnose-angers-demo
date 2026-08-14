<?php
/**
 * Approche du praticien.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--tinted" id="approche">
	<div class="wrap grid-two">
		<div class="reveal">
			<p class="eyebrow"><?php esc_html_e( 'L\'approche', 'maxime-hypnose' ); ?></p>
			<h2><?php esc_html_e( 'Vous rendre autonome, pas dépendant du cabinet', 'maxime-hypnose' ); ?></h2>
			<p>
				<?php esc_html_e( 'La plupart des difficultés que je reçois viennent d\'une gestion devenue défaillante des émotions et des mécanismes de pensée. Les pensées produisent les émotions, les émotions produisent les réactions. Agir sur ce mécanisme change la chaîne entière.', 'maxime-hypnose' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'Mon travail n\'est donc pas de vous « réparer » pendant que vous dormez, mais de vous transmettre des outils que vous réutilisez seul, longtemps après la dernière séance.', 'maxime-hypnose' ); ?>
			</p>
			<a class="link-arrow" href="<?php echo esc_url( home_url( '/qui-suis-je/' ) ); ?>">
				<?php esc_html_e( 'Mon parcours et ma formation', 'maxime-hypnose' ); ?>
				<?php mh_the_icon( 'arrow-right', 18 ); ?>
			</a>
		</div>

		<div class="reveal">
			<div class="card card--feature">
				<h3><?php esc_html_e( 'Ce que l\'hypnose n\'est pas', 'maxime-hypnose' ); ?></h3>
				<ul class="info-list" style="margin-top:var(--sp-4)">
					<li>
						<?php mh_the_icon( 'check', 20 ); ?>
						<span><strong><?php esc_html_e( 'Vous ne perdez pas le contrôle.', 'maxime-hypnose' ); ?></strong>
						<?php esc_html_e( 'Vous entendez tout, vous pouvez parler, ouvrir les yeux, arrêter à tout moment.', 'maxime-hypnose' ); ?></span>
					</li>
					<li>
						<?php mh_the_icon( 'check', 20 ); ?>
						<span><strong><?php esc_html_e( 'Rien à voir avec l\'hypnose de spectacle.', 'maxime-hypnose' ); ?></strong>
						<?php esc_html_e( 'Aucun test de suggestibilité, aucune mise en scène.', 'maxime-hypnose' ); ?></span>
					</li>
					<li>
						<?php mh_the_icon( 'check', 20 ); ?>
						<span><strong><?php esc_html_e( 'Ce n\'est pas un substitut médical.', 'maxime-hypnose' ); ?></strong>
						<?php esc_html_e( 'L\'accompagnement vient en complément d\'un suivi, jamais à sa place.', 'maxime-hypnose' ); ?></span>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>
