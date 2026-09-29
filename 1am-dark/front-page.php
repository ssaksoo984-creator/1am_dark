<?php
/**
 * Home (Dark)
 * Neon intro → 01 Slim HYBRID statement → What's your colour? → 02 Orbit (device features)
 * → 03 Product lines → 04 Why stock 1AM → 05 Vision / Promise → Stock 1AM.
 */
get_header();

get_template_part( 'template-parts/nx-intro' );
get_template_part( 'template-parts/nx-hello' );
get_template_part( 'template-parts/nx-colors' );
get_template_part( 'template-parts/nx-orbit' );
get_template_part( 'template-parts/nx-lines' );
get_template_part( 'template-parts/nx-features' );
get_template_part( 'template-parts/nx-vision' );
get_template_part( 'template-parts/nx-cta' );

get_footer();
