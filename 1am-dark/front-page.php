<?php
/**
 * Home (Dark)
 * Neon intro → 01 statement → flavour banner → 02 Orbit (brand features)
 * → 03 Product lines → 04 Why stock 1AM → 05 Vision / Promise → Stock 1AM.
 */
get_header();

get_template_part( 'template-parts/nx-intro' );
get_template_part( 'template-parts/nx-hello' );
get_template_part( 'template-parts/nx-banner' );
get_template_part( 'template-parts/nx-orbit' );
get_template_part( 'template-parts/nx-lines' );
get_template_part( 'template-parts/nx-features' );
// 05 + Stock 1AM 은 네온관·연기 배경을 함께 씀
?>
<div class="nx-finale" id="finale">
	<div class="nx-finale__bg" aria-hidden="true">
		<div class="nx-finale__glow"></div>
		<span class="nx-tube nx-tube--cyan"></span>
		<span class="nx-tube nx-tube--pink"></span>
		<canvas class="nx-smoke" data-smoke="16" data-strength="1.8"></canvas>
	</div>
	<?php
	get_template_part( 'template-parts/nx-vision' );
	get_template_part( 'template-parts/nx-cta' );
	?>
</div>
<?php

get_footer();
