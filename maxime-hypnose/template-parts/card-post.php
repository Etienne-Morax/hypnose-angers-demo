<?php
/**
 * Carte d'article, réutilisée sur l'accueil, le blog et les archives.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

$mh_is_lead = isset( $args['lead'] ) && true === $args['lead'];
?>
<article <?php post_class( 'post-card reveal' . ( $mh_is_lead ? ' post-card--lead' : '' ) ); ?>>
	<div class="post-card__media">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php
			the_post_thumbnail(
				$mh_is_lead ? 'mh-lead' : 'mh-card',
				array(
					'loading' => 'lazy',
					'alt'     => esc_attr( get_the_title() ),
				)
			);
			?>
		<?php endif; ?>
	</div>

	<div class="post-card__body">
		<?php mh_post_meta(); ?>

		<h3 class="post-card__title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>

		<p class="post-card__excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>

		<p class="post-card__foot"><?php esc_html_e( 'Lire l\'article', 'maxime-hypnose' ); ?> →</p>
	</div>
</article>
