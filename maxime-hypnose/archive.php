<?php
/**
 * Archives : catégories, étiquettes, dates, auteurs.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="page-hero">
	<div class="wrap">
		<?php mh_breadcrumbs(); ?>
		<p class="eyebrow"><?php esc_html_e( 'Archive', 'maxime-hypnose' ); ?></p>
		<h1><?php echo esc_html( wp_strip_all_tags( mh_current_title() ) ); ?></h1>
		<?php if ( term_description() ) : ?>
			<div class="lede"><?php echo wp_kses_post( term_description() ); ?></div>
		<?php endif; ?>
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

			<?php
			the_posts_pagination(
				array(
					'class'     => 'pagination',
					'mid_size'  => 1,
					'prev_text' => __( 'Précédent', 'maxime-hypnose' ),
					'next_text' => __( 'Suivant', 'maxime-hypnose' ),
				)
			);
			?>
		<?php else : ?>
			<p class="notice"><?php esc_html_e( 'Aucun article dans cette rubrique pour le moment.', 'maxime-hypnose' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
