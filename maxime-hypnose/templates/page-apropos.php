<?php
/**
 * Template Name: Qui suis-je ?
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="page-hero">
	<div class="wrap">
		<?php mh_breadcrumbs(); ?>
		<p class="eyebrow"><?php esc_html_e( 'Qui suis-je ?', 'maxime-hypnose' ); ?></p>
		<h1><?php echo esc_html( mh_get( 'mh_practitioner' ) ); ?></h1>
		<p class="lede"><?php esc_html_e( 'Hypnothérapeute à Avrillé depuis 2013, formateur en hypnose.', 'maxime-hypnose' ); ?></p>
	</div>
</section>

<section class="section">
	<div class="wrap grid-two">
		<div class="reveal">
			<h2><?php esc_html_e( 'Comment j\'en suis arrivé là', 'maxime-hypnose' ); ?></h2>
			<p>
				<?php esc_html_e( 'En 2012, je découvre des vidéos d\'hypnose de rue. Ce qui me frappe n\'est pas le spectacle, mais la rapidité avec laquelle un comportement peut changer. Je m\'entraîne, d\'abord seul devant un miroir, puis auprès d\'amis, puis dans la rue, les parcs, les bars.', 'maxime-hypnose' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'Cette pratique empirique atteint vite ses limites : elle produit des effets sans que j\'en comprenne les mécanismes. Je m\'inscris alors à l\'école de relaxologie et d\'hypnose des Ponts-de-Cé, où la théorie rejoint enfin la pratique, avec des formateurs à la fois exigeants et bienveillants.', 'maxime-hypnose' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'J\'ouvre mon cabinet à l\'issue de cette formation, en 2013. Je forme aujourd\'hui à mon tour de futurs praticiens.', 'maxime-hypnose' ); ?>
			</p>
		</div>

		<div class="reveal">
			<div class="card card--feature">
				<h3><?php esc_html_e( 'Repères', 'maxime-hypnose' ); ?></h3>
				<ul class="info-list" style="margin-top:var(--sp-4)">
					<li><?php mh_the_icon( 'shield', 20 ); ?><span><strong><?php esc_html_e( '2013 — Diplôme', 'maxime-hypnose' ); ?></strong><span><?php esc_html_e( 'Institut de formation aux techniques de relaxation, Les Ponts-de-Cé.', 'maxime-hypnose' ); ?></span></span></li>
					<li><?php mh_the_icon( 'user', 20 ); ?><span><strong><?php esc_html_e( 'Formateur', 'maxime-hypnose' ); ?></strong><span><?php esc_html_e( 'Transmission de l\'hypnose à de futurs praticiens.', 'maxime-hypnose' ); ?></span></span></li>
					<li><?php mh_the_icon( 'leaf', 20 ); ?><span><strong><?php esc_html_e( 'Hypnose moderne', 'maxime-hypnose' ); ?></strong><span><?php esc_html_e( 'Approche conversationnelle, orientée autonomie et attention.', 'maxime-hypnose' ); ?></span></span></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="section section--inverse">
	<div class="wrap">
		<div class="section__head reveal" style="max-width:44rem">
			<p class="eyebrow"><?php esc_html_e( 'Ma conviction', 'maxime-hypnose' ); ?></p>
			<h2><?php esc_html_e( '« Une thérapie réussie est une thérapie dont on sort sans avoir besoin d\'y revenir. »', 'maxime-hypnose' ); ?></h2>
			<p class="lede">
				<?php esc_html_e( 'C\'est pourquoi chaque séance se termine par la transmission d\'outils concrets. Vous devez pouvoir agir seul face à la prochaine situation difficile.', 'maxime-hypnose' ); ?>
			</p>
		</div>
	</div>
</section>

<?php if ( trim( get_the_content() ) !== '' ) : ?>
	<section class="section">
		<div class="entry-content">
			<?php
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
			?>
		</div>
	</section>
<?php endif; ?>

<?php
get_template_part( 'template-parts/section', 'contact' );
get_footer();
