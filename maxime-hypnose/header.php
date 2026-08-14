<?php
/**
 * En-tête du site.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#f7f4ec">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main"><?php esc_html_e( 'Aller au contenu principal', 'maxime-hypnose' ); ?></a>

<header class="site-header" id="site-header">
	<div class="wrap site-header__inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<svg class="brand__mark" viewBox="0 0 40 40" aria-hidden="true" focusable="false">
					<circle cx="20" cy="20" r="19" fill="#1f3830"/>
					<circle cx="20" cy="20" r="12.5" fill="none" stroke="#f7f4ec" stroke-opacity="0.4"/>
					<circle cx="20" cy="20" r="7" fill="none" stroke="#f7f4ec" stroke-opacity="0.6"/>
					<circle cx="20" cy="20" r="3" fill="#c2703f"/>
				</svg>
				<span class="brand__name">
					<?php echo esc_html( mh_get( 'mh_practitioner' ) ); ?>
					<span class="brand__role"><?php esc_html_e( 'Hypnothérapeute · Angers', 'maxime-hypnose' ); ?></span>
				</span>
			<?php endif; ?>
		</a>

		<nav class="site-nav" id="site-nav" aria-label="<?php esc_attr_e( 'Navigation principale', 'maxime-hypnose' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => '',
					'depth'          => 1,
					'fallback_cb'    => false,
				)
			);
			?>
			<div class="site-nav__cta">
				<a class="btn btn--primary" href="<?php echo esc_url( mh_get( 'mh_booking_url' ) ); ?>">
					<?php esc_html_e( 'Prendre rendez-vous', 'maxime-hypnose' ); ?>
				</a>
				<a class="btn btn--ghost" href="<?php echo esc_url( mh_phone_link() ); ?>">
					<?php mh_the_icon( 'phone', 18 ); ?>
					<?php echo esc_html( mh_get( 'mh_phone' ) ); ?>
				</a>
			</div>
		</nav>

		<div class="header-actions">
			<a class="header-phone" href="<?php echo esc_url( mh_phone_link() ); ?>">
				<?php mh_the_icon( 'phone', 18 ); ?>
				<span><?php echo esc_html( mh_get( 'mh_phone' ) ); ?></span>
			</a>
			<a class="btn btn--primary btn--sm" href="<?php echo esc_url( mh_get( 'mh_booking_url' ) ); ?>">
				<?php esc_html_e( 'Rendez-vous', 'maxime-hypnose' ); ?>
			</a>
			<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav">
				<span class="screen-reader-text"><?php esc_html_e( 'Ouvrir le menu', 'maxime-hypnose' ); ?></span>
				<span class="nav-toggle__bar"></span>
				<span class="nav-toggle__bar"></span>
				<span class="nav-toggle__bar"></span>
			</button>
		</div>
	</div>
</header>

<main id="main" class="site-main">
