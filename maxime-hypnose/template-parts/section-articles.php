<?php
/**
 * Derniers articles du blog.
 * Section clé : c'est ici qu'apparaissent les pages publiées automatiquement.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

$mh_latest = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);

if ( ! $mh_latest->have_posts() ) {
	return;
}
?>
<section class="section" id="articles">
	<div class="wrap">
		<div class="section__head section__head--split reveal">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Le blog', 'maxime-hypnose' ); ?></p>
				<h2><?php esc_html_e( 'Comprendre avant de consulter', 'maxime-hypnose' ); ?></h2>
			</div>
			<p class="lede">
				<?php esc_html_e( 'Des réponses écrites aux questions qui reviennent le plus souvent en cabinet.', 'maxime-hypnose' ); ?>
			</p>
		</div>

		<div class="post-grid">
			<?php
			while ( $mh_latest->have_posts() ) :
				$mh_latest->the_post();
				get_template_part( 'template-parts/card', 'post' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>

		<p style="margin-top:var(--sp-6)">
			<a class="link-arrow" href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">
				<?php esc_html_e( 'Tous les articles', 'maxime-hypnose' ); ?>
				<?php mh_the_icon( 'arrow-right', 18 ); ?>
			</a>
		</p>
	</div>
</section>
