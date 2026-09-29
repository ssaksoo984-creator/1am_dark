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
get_template_part( 'template-parts/nx-vision' );
get_template_part( 'template-parts/nx-cta' );

get_footer();
