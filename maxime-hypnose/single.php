<?php
/**
 * Article seul.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class(); ?>>
		<header class="article-hero">
			<div class="wrap wrap--narrow">
				<?php mh_breadcrumbs(); ?>
				<h1><?php the_title(); ?></h1>

				<div class="article-hero__meta">
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					<span aria-hidden="true">·</span>
					<span>
						<?php
						echo esc_html(
							sprintf(
								/* translators: %d: minutes. */
								__( '%d min de lecture', 'maxime-hypnose' ),
								mh_reading_time( get_the_content() )
							)
						);
						?>
					</span>
					<?php if ( has_category() ) : ?>
						<span aria-hidden="true">·</span>
						<span><?php the_category( ', ' ); ?></span>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="wrap article-featured">
					<?php the_post_thumbnail( 'mh-lead', array( 'fetchpriority' => 'high' ) ); ?>
				</div>
			<?php endif; ?>
		</header>

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

			<?php if ( has_tag() ) : ?>
				<div class="entry-tags"><?php the_tags( '', '', '' ); ?></div>
			<?php endif; ?>

			<div class="author-box">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 136, '', get_the_author(), array( 'class' => 'author-box__avatar' ) ); ?>
				<div>
					<strong><?php echo esc_html( get_the_author() ); ?></strong>
					<p><?php echo esc_html( get_the_author_meta( 'description' ) ?: __( 'Hypnothérapeute à Avrillé, près d\'Angers.', 'maxime-hypnose' ) ); ?></p>
				</div>
			</div>

			<div class="post-cta">
				<h2><?php esc_html_e( 'Une question sur votre situation ?', 'maxime-hypnose' ); ?></h2>
				<p><?php esc_html_e( 'Un appel de quelques minutes suffit souvent à savoir si l\'hypnose est la bonne approche pour vous.', 'maxime-hypnose' ); ?></p>
				<a class="btn btn--light" href="<?php echo esc_url( mh_get( 'mh_booking_url' ) ); ?>">
					<?php esc_html_e( 'Prendre rendez-vous', 'maxime-hypnose' ); ?>
				</a>
			</div>

			<nav class="post-nav" aria-label="<?php esc_attr_e( 'Articles précédent et suivant', 'maxime-hypnose' ); ?>">
				<?php
				$mh_prev = get_previous_post();
				$mh_next = get_next_post();
				?>
				<?php if ( $mh_prev ) : ?>
					<a href="<?php echo esc_url( (string) get_permalink( $mh_prev ) ); ?>">
						<span><?php esc_html_e( 'Article précédent', 'maxime-hypnose' ); ?></span>
						<strong><?php echo esc_html( get_the_title( $mh_prev ) ); ?></strong>
					</a>
				<?php endif; ?>
				<?php if ( $mh_next ) : ?>
					<a href="<?php echo esc_url( (string) get_permalink( $mh_next ) ); ?>">
						<span><?php esc_html_e( 'Article suivant', 'maxime-hypnose' ); ?></span>
						<strong><?php echo esc_html( get_the_title( $mh_next ) ); ?></strong>
					</a>
				<?php endif; ?>
			</nav>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
