<?php
/**
 * Pied de page et barre d'action mobile.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;
?>
</main>

<footer class="site-footer">
	<div class="wrap">
		<div class="footer__grid">
			<div class="footer__brand">
				<p class="footer__title"><?php echo esc_html( mh_get( 'mh_practitioner' ) ); ?></p>
				<p style="max-width:32ch">
					<?php esc_html_e( 'Cabinet d\'hypnose à Avrillé, aux portes d\'Angers. Accompagnement en hypnose moderne, orienté autonomie.', 'maxime-hypnose' ); ?>
				</p>
				<div class="badge-row">
					<span class="badge"><?php mh_the_icon( 'shield', 16 ); ?><?php esc_html_e( 'Praticien certifié', 'maxime-hypnose' ); ?></span>
					<span class="badge"><?php mh_the_icon( 'user', 16 ); ?><?php esc_html_e( 'Formateur en hypnose', 'maxime-hypnose' ); ?></span>
				</div>
			</div>

			<div>
				<p class="footer__title"><?php esc_html_e( 'Le cabinet', 'maxime-hypnose' ); ?></p>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => '',
						'menu_class'     => 'footer__list',
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
				?>
			</div>

			<div>
				<p class="footer__title"><?php esc_html_e( 'Contact', 'maxime-hypnose' ); ?></p>
				<ul class="footer__list">
					<li><a href="<?php echo esc_url( mh_phone_link() ); ?>"><?php echo esc_html( mh_get( 'mh_phone' ) ); ?></a></li>
					<li><a href="mailto:<?php echo esc_attr( mh_get( 'mh_email' ) ); ?>"><?php echo esc_html( mh_get( 'mh_email' ) ); ?></a></li>
					<li>
						<a href="<?php echo esc_url( mh_get( 'mh_maps_url' ) ); ?>" target="_blank" rel="noopener noreferrer">
							<?php echo esc_html( mh_get( 'mh_address' ) ); ?>
						</a>
					</li>
				</ul>
			</div>

			<div>
				<p class="footer__title"><?php esc_html_e( 'Horaires', 'maxime-hypnose' ); ?></p>
				<ul class="footer__list">
					<li><?php echo esc_html( mh_get( 'mh_hours_week' ) ); ?></li>
					<li><?php echo esc_html( mh_get( 'mh_hours_sat' ) ); ?></li>
					<li><?php esc_html_e( 'Sur rendez-vous uniquement', 'maxime-hypnose' ); ?></li>
				</ul>
			</div>
		</div>

		<div class="footer__bottom">
			<p style="margin:0">
				&copy; <?php echo esc_html( (string) gmdate( 'Y' ) ); ?> <?php echo esc_html( mh_get( 'mh_practitioner' ) ); ?>.
				<?php esc_html_e( 'L\'hypnose ne remplace pas un avis médical.', 'maxime-hypnose' ); ?>
			</p>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'legal',
					'container'      => '',
					'menu_class'     => 'footer__legal',
					'depth'          => 1,
					'fallback_cb'    => false,
				)
			);
			?>
		</div>
	</div>
</footer>

<div class="mobile-cta">
	<a class="btn btn--ghost" href="<?php echo esc_url( mh_phone_link() ); ?>">
		<?php mh_the_icon( 'phone', 18 ); ?>
		<?php esc_html_e( 'Appeler', 'maxime-hypnose' ); ?>
	</a>
	<a class="btn btn--primary" href="<?php echo esc_url( mh_get( 'mh_booking_url' ) ); ?>">
		<?php esc_html_e( 'Rendez-vous', 'maxime-hypnose' ); ?>
	</a>
</div>

<?php wp_footer(); ?>
</body>
</html>
