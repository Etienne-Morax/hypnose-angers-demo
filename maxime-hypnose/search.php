<?php
/**
 * Résultats de recherche.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="page-hero">
	<div class="wrap">
		<?php mh_breadcrumbs(); ?>
		<p class="eyebrow"><?php esc_html_e( 'Recherche', 'maxime-hypnose' ); ?></p>
		<h1>
			<?php
			printf(
				/* translators: %s: search query. */
				esc_html__( 'Résultats pour « %s »', 'maxime-hypnose' ),
				esc_html( get_search_query() )
			);
			?>
		</h1>
		<div style="max-width:32rem;margin-top:var(--sp-5)"><?php get_search_form(); ?></div>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/card', 'post' );
				endwhile;
				?>
			</div>

			<?php the_posts_pagination( array( 'class' => 'pagination' ) ); ?>
		<?php else : ?>
			<div class="notice">
				<strong><?php esc_html_e( 'Aucun résultat.', 'maxime-hypnose' ); ?></strong>
				<?php esc_html_e( 'Essayez un terme plus court, ou appelez directement le cabinet.', 'maxime-hypnose' ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
