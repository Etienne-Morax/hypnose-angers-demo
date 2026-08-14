<?php
/**
 * Commentaires — désactivés par défaut sur un site vitrine, mais stylés si activés.
 *
 * @package MaximeHypnose
 */

defined( 'ABSPATH' ) || exit;

if ( post_password_required() ) {
	return;
}
?>
<section class="comments" id="comments" style="margin-top:var(--sp-8)">
	<?php if ( have_comments() ) : ?>
		<h2>
			<?php
			printf(
				/* translators: %d: comment count. */
				esc_html( _n( '%d commentaire', '%d commentaires', get_comments_number(), 'maxime-hypnose' ) ),
				(int) get_comments_number()
			);
			?>
		</h2>

		<ol class="comment-list" style="list-style:none;padding:0;display:grid;gap:var(--sp-5)">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php the_comments_pagination( array( 'class' => 'pagination' ) ); ?>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_submit'  => 'btn btn--primary',
			'title_reply'   => __( 'Laisser un commentaire', 'maxime-hypnose' ),
			'comment_notes_before' => '<p class="field__hint">' . esc_html__( 'Votre adresse email ne sera pas publiée.', 'maxime-hypnose' ) . '</p>',
		)
	);
	?>
</section>
