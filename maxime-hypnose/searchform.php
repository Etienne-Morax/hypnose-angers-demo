<?php
/**
 * Formulaire de recherche.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

$mh_id = 'search-' . wp_unique_id();
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="field">
		<label for="<?php echo esc_attr( $mh_id ); ?>" class="screen-reader-text">
			<?php esc_html_e( 'Rechercher sur le site', 'maxime-hypnose' ); ?>
		</label>
		<div style="display:flex;gap:var(--sp-2)">
			<input type="search" id="<?php echo esc_attr( $mh_id ); ?>" name="s"
				value="<?php echo esc_attr( get_search_query() ); ?>"
				placeholder="<?php esc_attr_e( 'Rechercher un article…', 'maxime-hypnose' ); ?>">
			<button class="btn btn--primary" type="submit"><?php esc_html_e( 'Chercher', 'maxime-hypnose' ); ?></button>
		</div>
	</div>
</form>
