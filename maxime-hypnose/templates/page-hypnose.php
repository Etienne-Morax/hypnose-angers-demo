<?php
/**
 * Template Name: L'hypnose
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="page-hero">
	<div class="wrap">
		<?php mh_breadcrumbs(); ?>
		<p class="eyebrow"><?php esc_html_e( 'Comprendre', 'maxime-hypnose' ); ?></p>
		<h1><?php esc_html_e( 'L\'hypnose, sans mystère', 'maxime-hypnose' ); ?></h1>
		<p class="lede">
			<?php esc_html_e( 'Un état naturel que vous traversez plusieurs fois par jour, utilisé ici de manière ciblée et volontaire.', 'maxime-hypnose' ); ?>
		</p>
	</div>
</section>

<section class="section">
	<div class="wrap grid-two">
		<div class="reveal">
			<h2><?php esc_html_e( 'Un état ordinaire, pas un pouvoir', 'maxime-hypnose' ); ?></h2>
			<p>
				<?php esc_html_e( 'Vous conduisez et arrivez sans avoir mémorisé le trajet. Vous lisez et n\'entendez plus qu\'on vous parle. Ces moments sont des états hypnotiques spontanés : l\'attention se concentre sur un point et le reste passe au second plan.', 'maxime-hypnose' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'En séance, je ne fais rien d\'autre que provoquer volontairement cet état, puis l\'orienter vers ce que vous souhaitez changer. Aucune force extérieure n\'agit sur vous : c\'est votre propre fonctionnement qu\'on met au travail.', 'maxime-hypnose' ); ?>
			</p>
		</div>
		<div class="reveal">
			<div class="card card--feature">
				<h3><?php esc_html_e( 'En pratique, pendant la séance', 'maxime-hypnose' ); ?></h3>
				<ul class="info-list" style="margin-top:var(--sp-4)">
					<li><?php mh_the_icon( 'check', 20 ); ?><span><?php esc_html_e( 'Vous restez assis ou allongé, habillé, libre de bouger.', 'maxime-hypnose' ); ?></span></li>
					<li><?php mh_the_icon( 'check', 20 ); ?><span><?php esc_html_e( 'Vous entendez ma voix et l\'environnement.', 'maxime-hypnose' ); ?></span></li>
					<li><?php mh_the_icon( 'check', 20 ); ?><span><?php esc_html_e( 'Vous gardez la mémoire de la séance.', 'maxime-hypnose' ); ?></span></li>
					<li><?php mh_the_icon( 'check', 20 ); ?><span><?php esc_html_e( 'Vous ne direz ni ne ferez rien contre vos valeurs.', 'maxime-hypnose' ); ?></span></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="section section--inverse">
	<div class="wrap">
		<div class="section__head reveal">
			<p class="eyebrow"><?php esc_html_e( 'Mécanisme', 'maxime-hypnose' ); ?></p>
			<h2><?php esc_html_e( 'Pourquoi ça agit là où la volonté échoue', 'maxime-hypnose' ); ?></h2>
		</div>
		<div class="steps">
			<article class="step reveal">
				<h3><?php esc_html_e( 'La pensée déclenche', 'maxime-hypnose' ); ?></h3>
				<p><?php esc_html_e( 'Une situation active une pensée automatique, souvent hors de votre champ de conscience.', 'maxime-hypnose' ); ?></p>
			</article>
			<article class="step reveal">
				<h3><?php esc_html_e( 'L\'émotion suit', 'maxime-hypnose' ); ?></h3>
				<p><?php esc_html_e( 'Cette pensée produit une émotion : peur, envie, tension, urgence.', 'maxime-hypnose' ); ?></p>
			</article>
			<article class="step reveal">
				<h3><?php esc_html_e( 'La réaction s\'impose', 'maxime-hypnose' ); ?></h3>
				<p><?php esc_html_e( 'La cigarette, l\'évitement, la crise. Décider « d\'arrêter » agit trop tard dans la chaîne.', 'maxime-hypnose' ); ?></p>
			</article>
			<article class="step reveal">
				<h3><?php esc_html_e( 'On remonte en amont', 'maxime-hypnose' ); ?></h3>
				<p><?php esc_html_e( 'L\'hypnose intervient au niveau du déclencheur, pas de la réaction finale.', 'maxime-hypnose' ); ?></p>
			</article>
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
get_template_part( 'template-parts/section', 'faq' );
get_template_part( 'template-parts/section', 'contact' );
get_footer();
