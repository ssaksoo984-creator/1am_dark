<?php
/**
 * 01 — 큰 글자 사이를 제품이 대각선으로 관통 + 짧은 소개
 */
$flavors = oneam_get_flavors();
$hero    = $flavors[ min( 4, count( $flavors ) - 1 ) ];
$lines   = preg_split( '/\r?\n/', trim( oneam_opt( 'oneam_hello_title' ) ) );
?>
<section class="nx-hello" id="hello" style="<?php echo oneam_flavor_style( $hero ); // phpcs:ignore ?>">
	<span class="nx-num" aria-hidden="true">01</span>
	<div class="nx-hello__type" aria-hidden="true">
		<div class="nx-hello__words">
			<?php foreach ( $lines as $l ) : ?><span><?php echo esc_html( $l ); ?></span><?php endforeach; ?>
		</div>
		<img class="nx-hello__device" src="<?php echo esc_url( $hero['img'] ); ?>" alt="" width="246" height="1400" loading="lazy">
	</div>
	<div class="nx-hello__copy">
		<h2 class="nx-h2" data-reveal><span class="line"><span><?php echo oneam_rich( oneam_opt( 'oneam_hello_head' ) ); // phpcs:ignore ?></span></span></h2>
		<p class="nx-sub"><?php echo esc_html( wp_strip_all_tags( str_replace( '*', '', oneam_opt( 'oneam_about_title' ) ) ) ); ?></p>
		<p class="nx-p"><?php echo esc_html( oneam_opt( 'oneam_about_text' ) ); ?></p>
		<a class="nx-link" href="<?php echo esc_url( oneam_opt( 'oneam_about_url' ) ); ?>"><span>Learn more</span><i class="nx-circle" aria-hidden="true">&rarr;</i></a>
	</div>
</section>
