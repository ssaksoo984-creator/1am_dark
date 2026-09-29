<?php
/**
 * 마지막 — 네온사인처럼 깜빡이며 켜지는 Stock 1AM.
 */
?>
<section class="nx-cta" id="wholesale">
	<div class="nx-cta__bg" aria-hidden="true"><img src="<?php echo esc_url( oneam_asset( 'img/scene-tilt.webp' ) ); ?>" alt="" width="1932" height="814" loading="lazy"></div>
	<span class="nx-cta__line" aria-hidden="true"></span>
	<h2 class="nx-cta__title" data-neon><?php echo oneam_rich( oneam_opt( 'oneam_cta_title' ) ); // phpcs:ignore ?></h2>
	<p class="nx-p nx-cta__text"><?php echo esc_html( oneam_opt( 'oneam_cta_text' ) ); ?></p>
	<div class="nx-cta__btns">
		<?php oneam_member_cta( 'btn--xl' ); ?>
		<?php if ( 'guest' === oneam_member_state() ) : ?>
			<a class="btn btn--ghost btn--xl" href="<?php echo esc_url( oneam_login_url() ); ?>" data-magnetic><span>Log in</span></a>
		<?php endif; ?>
	</div>
	<p class="nx-meta">Retailers only &middot; <?php echo (int) oneam_opt( 'oneam_min_age' ); ?>+ &middot; Canada</p>
</section>
