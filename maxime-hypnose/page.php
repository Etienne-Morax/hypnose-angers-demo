<?php
/**
 * Page générique — utilisée par les pages créées à la main ou par un outil externe.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<section class="page-hero">
		<div class="wrap">
			<?php mh_breadcrumbs(); ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( has_post_thumbnail() ) : ?>
		<div class="wrap article-featured"><?php the_post_thumbnail( 'mh-lead' ); ?></div>
	<?php endif; ?>

	<section class="section">
		<div class="entry-content">
			<?php
			the_content();

			wp_link_pages(
				array(
					'before' => '<nav class="page-links">',
					'after'  => '</nav>',
				)
			);
			?>
		</div>
	</section>
	<?php
endwhile;

get_footer();
