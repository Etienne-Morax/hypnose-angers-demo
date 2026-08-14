<?php
/**
 * Liste des articles — page du blog et repli général.
 * C'est la vue qui accueille les publications générées automatiquement.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="page-hero">
	<div class="wrap">
		<?php mh_breadcrumbs(); ?>
		<p class="eyebrow"><?php esc_html_e( 'Le blog', 'maxime-hypnose' ); ?></p>
		<h1><?php echo esc_html( is_home() && get_option( 'page_for_posts' ) ? get_the_title( get_option( 'page_for_posts' ) ) : __( 'Articles', 'maxime-hypnose' ) ); ?></h1>
		<p class="lede">
			<?php esc_html_e( 'Comprendre l\'hypnose, ses mécanismes et ses limites — sans jargon et sans promesse excessive.', 'maxime-hypnose' ); ?>
		</p>
	</div>
</section>

<section class="section">
	<div class="wrap">
		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php
				$mh_index = 0;

				while ( have_posts() ) :
					the_post();

					get_template_part(
						'template-parts/card',
						'post',
						array( 'lead' => 0 === $mh_index && ! is_paged() )
					);

					$mh_index++;
				endwhile;
				?>
			</div>

			<?php
			the_posts_pagination(
				array(
					'class'              => 'pagination',
					'mid_size'           => 1,
					'prev_text'          => __( 'Précédent', 'maxime-hypnose' ),
					'next_text'          => __( 'Suivant', 'maxime-hypnose' ),
					'screen_reader_text' => __( 'Navigation dans les articles', 'maxime-hypnose' ),
				)
			);
			?>
		<?php else : ?>
			<div class="notice">
				<strong><?php esc_html_e( 'Aucun article pour le moment.', 'maxime-hypnose' ); ?></strong>
				<?php esc_html_e( 'Les prochaines publications apparaîtront ici automatiquement.', 'maxime-hypnose' ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_template_part( 'template-parts/section', 'contact' );
get_footer();
